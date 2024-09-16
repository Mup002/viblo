<div>
 
    <p>

        Hi {{ $username}},

        Thanks for getting started with our [customer portal]!

        We need a little more information to complete your registration, including a confirmation of your email address.

        Click below to confirm your email address:

        <a href="{{ route('verify', ['token' => $verify_token]) }}">Verify your email</a>

        If you have problems, please paste the above URL into your web browser.
    </p>
</div>