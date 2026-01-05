@extends('Auth.layout')

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Login</b></h3>
                    <a href="{{ route('admin.register') }}" class="link-primary">Don't have an account?</a>
                </div>
                <form action="">
                    <div class="form-group mb-3">
                        <label class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control" placeholder="Email Address">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Password</label>
                        <input id="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="d-flex mt-1 justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                            <label class="form-check-label text-muted" for="customCheckc1">Keep me sign in</label>
                        </div>
                        <h5 class="text-secondary f-w-400">Forgot Password?</h5>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="button" class="btn btn-primary" onclick="login()">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".form-control").on("input", function() {
            $(this).removeClass("is-invalid");
        });

        const API_TOKEN = "{{ session('api_token') }}";

        const login = () => {
            const BASE_URL = "{{ route('admin.authentication') }}";
            const METHOD = "POST";

            const formData = new FormData();
            formData.append('email', $("#email").val());
            formData.append('password', $("#password").val());
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: BASE_URL,
                type: METHOD,
                headers: {
                    'Authorization': 'Bearer ' + API_TOKEN,
                    'Accept': 'application/json'
                },
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    if (!response.success) {
                        $(".form-control").removeClass("is-invalid");

                        $.each(response.message, function(field, messages) {
                            $("#" + field).addClass("is-invalid");
                            $("#" + field + "Feedback").text(messages[0]);
                        });
                        return;
                    }
                    toast('success', response.message);
                    window.location.href = "/admin/dashboard";
                },
                error: function(xhr, status, error) {
                    toast('error', error);
                }
            });
        }
    </script>
@endsection
