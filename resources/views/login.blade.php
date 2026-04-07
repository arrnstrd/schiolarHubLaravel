

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background-color: #212121;">


	<div class="d-flex flex-column justify-content-center align-items-center vh-100 ">  
	    <div class="col-11 col-sm-8 col-md-6 col-lg-4 col-xl-3 p-5 shadow-sm" style="border-radius: 20px; background-color:#F5F7FF;"> 	        
	        <div class="text-center mb-4">
	            <i class="fa-solid fa-book-open text-light fs-4 p-4 rounded" style="background-color: #212121;"></i>
	            <h3 class="mt-3 fw-bold" style="color: #212121;">Welcome Back</h3>
	            <p class="text-muted">Let's pick up right where you left off.</p>
	        </div>

	        <form class="text-start" method="POST" action="/login" > 
                @csrf
	        	<div class="form-group mb-3">
	                <label for="email" class="text-muted small fw-bold">Email Address</label>
	                <input type="email" class="form-control p-2" name="email" id="email" placeholder="name@email.com" style="border-radius: 8px;">
	            </div>

	            <div class="form-group mb-2">
	                <label for="password" class="text-muted small fw-bold">Password</label>
	                <input type="password" class="form-control p-2"  name="password" id="password" placeholder="Enter your password" style="border-radius: 8px;">
	            </div>

	            <div class="text-end mb-4">
	                <a href="/recoverPass" class="small text-decoration-none">Forgot password?</a>
	            </div>

	            <button type="submit" class="btn btn-dark w-100 p-2 fw-bold mb-4" style="border-radius: 8px;">Log in</button>
	            
	            <p class="text-center small text-muted">
	                Don't have an account? <a href="/register" class="fw-bold text-decoration-none">Register here</a>
	            </p>
	            
	        </form>
	    </div>
	</div>




 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>