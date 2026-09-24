<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow-sm rounded-4 overflow-hidden mx-auto w-100" style="max-width: 600px;">

        <div class="card-header bg-primary text-white text-center py-4 border-0">
            <h2 class="h4 fw-semibold mb-0">
                {{ \Illuminate\Support\Facades\Lang::get('messages.emails.first-access.title') }}
            </h2>
        </div>

        <div class="card-body text-center p-4 p-md-5">

            <h1 class="display-6 fw-bold mb-4">
                {{ \Illuminate\Support\Facades\Lang::get('messages.welcome') }}
            </h1>

            <p class="text-body-secondary mb-4">
                {{ \Illuminate\Support\Facades\Lang::get('messages.greetings', ['name' => $name]) }}
            </p>

            <p class="text-body-secondary mb-4">
                {{ \Illuminate\Support\Facades\Lang::get('messages.emails.first-access.info') }}
            </p>

            <div class="bg-light border border-2 border-secondary border-opacity-25 border-dashed rounded-3 p-4 my-4">
                <div class="display-5 fw-bold text-primary">
                    {{ $code }}
                </div>

                <div class="small text-body-secondary mt-2">
                    {{ \Illuminate\Support\Facades\Lang::get('messages.this_is_your_code') }}
                </div>
            </div>

            <p class="text-body-secondary mb-4">
                {{ \Illuminate\Support\Facades\Lang::get('messages.emails.first-access.info_2') }}
            </p>
            <p class="text-body-secondary mb-4">
                {{ \Illuminate\Support\Facades\Lang::get('messages.emails.first-access.info_4') }}
                <span class="fw-semibold">{{ \Illuminate\Support\Facades\Lang::get('messages.in_minutes', ['minutes' => $expires_at]) }}</span>
            </p>

            <div class="alert alert-warning text-start mb-4" role="alert">
                <strong>
                    {{ \Illuminate\Support\Facades\Lang::get('messages.important') }}
                </strong>

                {{ \Illuminate\Support\Facades\Lang::get('messages.emails.first-access.info_3') }}
            </div>

            <p class="text-body-secondary mt-4 mb-0">
                {{ \Illuminate\Support\Facades\Lang::get('messages.yours_sincerely') }},
                <br>

                <strong class="text-body">
                    {{ \Illuminate\Support\Facades\Lang::get('messages.team') }}
                    {{ config('app.name') }}
                </strong>
            </p>

        </div>

        <div class="card-footer bg-light text-center p-4">

            <p class="small text-body-secondary mb-2">
                {{ \Illuminate\Support\Facades\Lang::get('messages.email_not_reply') }}
            </p>

            <p class="small text-body-secondary mb-0">
                &copy; {{ date('Y') }}
                {{ config('app.name') }}.
                {{ \Illuminate\Support\Facades\Lang::get('messages.all_rights_reserved') }}
            </p>

        </div>

    </div>

</div>

</body>

</html>
