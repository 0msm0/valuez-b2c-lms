<!DOCTYPE html>
<html>

<head>
    <title>LMS.com</title>
</head>

<body>
    <h3>Hi {{ $details['title'] }},</h3><br/>
    <p> Welcome to ValueZ LMS for {{ $details['school_name'] }}.<br/>
        Find your account details herewith.</p>
    <p>User Id : <strong>{{ $details['username'] }}</strong><br />
        Password : <strong>{{ $details['pass'] }}</strong>
    <p><br/>
    <p>This is a computer generated email. Please do not reply to this email.<br />
        For any queries you can reach out to support@valuezhut.com
    </p>
    <p> Regards<br />
        ValueZ Team</p>
</body>

</html>
