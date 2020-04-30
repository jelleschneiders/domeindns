@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Responsible disclosure</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p>We take the security of our systems seriously, and we value the security community. The disclosure of security vulnerabilities helps us ensure the security and privacy of our users.</p>


            <h3>Guidelines</h3>

            <p>We require that all researchers:</p>

            <ul>
                <li>Make every effort to avoid privacy violations, degradation of user experience, disruption to production systems, and destruction of data during security testing;</li>
                <li>Perform research only within the scope set out below; </li>
                <li>Use the identified communication channels to report vulnerability information to us; and</li>
                <li>Keep information about any vulnerabilities you’ve discovered confidential between yourself and DomeinDNS until we’ve had 90 days to resolve the issue.</li>
            </ul>

            <p>If you follow these guidelines when reporting an issue to us, we commit to:</p>

            <ul>
                <li>Not pursue or support any legal action related to your research;</li>
                <li>Work with you to understand and resolve the issue quickly (including an initial confirmation of your report within 72 hours of submission); </li>
            </ul>

            <h3>Scope</h3>
            <ul>
                <li>https://domeindns.nl</li>
                <li>https://app.domeindns.nl</li>
                <li>Our DNS servers: ns1.domeindns.nl / ns2.domeindns.nl / ns3.domeindns.org</li>
                <li>https://noc.domeindns.org</li>
            </ul>

            <h3>Out of scope</h3>
            <p>Any services hosted by 3rd party providers and services are excluded from scope.</p>
            <p>In the interest of the safety of our users, staff, the Internet at large and you as a security researcher, the following test types are excluded from scope: </p>

            <ul>
                <li>Findings from physical testing such as office access (e.g. open doors, tailgating)</li>
                <li>Findings derived primarily from social engineering (e.g. phishing, vishing)</li>
                <li>Findings from applications or systems not listed in the ‘Scope’ section</li>
                <li>UI and UX bugs and spelling mistakes</li>
                <li>Network level Denial of Service (DoS/DDoS) vulnerabilities</li>
            </ul>

            <p>Things we do not want to receive: </p>

            <ul>
                <li>Personally identifiable information (PII) </li>
            </ul>

            <h3>How to report a security vulnerability?</h3>
            If you believe you’ve found a security vulnerability in one of our products or platforms please send it to us by emailing info@domeindns.nl . Please include the following details with your report:</p>

            <ul>
                <li>Description of the location and potential impact of the vulnerability</li>
                <li>A detailed description of the steps required to reproduce the vulnerability (POC scripts, screenshots, and compressed screen captures are all helpful to us)</li></ul>
        </div>
    </div>
@endsection
