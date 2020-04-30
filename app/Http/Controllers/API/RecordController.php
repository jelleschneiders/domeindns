<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRecord;
use App\Jobs\DeleteRecord;
use App\Record;
use App\Status;
use App\User;
use App\Zone;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show(Request $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $zone = Zone::where([
            ['id', '=', $request->id],
            ['user_id', '=', $user->id],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        $getfields = $user->zones->where('id', $request->id)->map(function ($domains) {
            $domains['records'] = $domains->records()->select('id', 'record_type', 'ttl', 'name', 'content', 'status', 'created_at', 'updated_at')->where('status', '!=', Status::$PENDING_UPDATE_DELETION)->get();
            return $domains->only(['id', 'domain', 'records']);
        });

        return response()->json([
            'success' => true,
            'data' => $getfields]);
    }

    public function store(CreateRecord $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $zone = Zone::where([
            ['id', '=', $request->id],
            ['user_id', '=', $user->id],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        $record = Record::create_new($zone->id, $request['type'], $request['ttl'], $request['name'], $request['content']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $record->id,
                'record_type' => $record->record_type,
                'ttl' => $record->ttl,
                'name' => $record->name,
                'content' => $record->content,
                'status' => $record->status,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at,
            ]]);
    }

    public function destroy(Request $request)
    {
        $user = $this->authorizedUser($request->reseller_user);

        $zone = Zone::where([
            ['user_id', '=', $user->id],
            ['id', '=', $request->id],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        $record = $zone->records()->where('id', $request->recordid)->firstOrFail();
        $record['status'] = Status::$PENDING_DELETION;
        $record->update();

        $contentrecords = Record::where([
            ['name', $record->name],
            ['zone_id', $record->zone_id],
            ['record_type', $record->record_type],
            ['status', '=', Status::$OK]
        ])->get();

        DeleteRecord::dispatch($record);

        if($contentrecords->count() != 0) {
            foreach ($contentrecords as $contentrecord) {
                \App\Jobs\CreateRecord::dispatch($contentrecord);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function authorizedUser($reseller_user)
    {
        $user = auth()->user();
        if(isset($reseller_user)){
            $user = User::where([
                ['id', $reseller_user],
                ['managed_by', auth()->user()->id]
            ])->firstOrFail();
        }

        return $user;
    }
}
