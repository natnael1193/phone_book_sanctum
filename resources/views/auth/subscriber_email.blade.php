<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Your Email Address</div>
                  <div class="card-body">
                   @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                           {{ __('A fresh verification link has been sent to your email address.') }}
                       </div>
                   @endif

                      <p>We have sent you this email as we have received a request from you that you forgot your password.
                          Use the link below to reset your password.</p>
                   <a href="{{ url('https://hulum.et/'.$token) }}"> Click Here</a>
               </div>
           </div>
       </div>
   </div>
</div>