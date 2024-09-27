
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Number verification with OTP</title>
<!-- for demo only -->
<!-- <script src="../../../assets/js/script.demo.v0.06.js" defer></script> -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GCFCN7G09K"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-GCFCN7G09K');
</script>
<style>
	.container {
		width: 302px;
		height: 175px;
		position: absolute;
		left: 0px;
		right: 0px;
		top: 0px;
		bottom: 0px;
		margin: auto;
	}
	#number, #verificationcode {
		width: calc(100% - 24px);
		padding: 10px;
		font-size: 20px;
		margin-bottom: 5px;
		outline: none;
	}
	#recaptcha-container {
		margin-bottom: 5px;
	}
	#send, #verify {
		width: 100%;
		height: 40px;
		outline: none;
	}
	.p-conf, .n-conf {
		width: calc(100% - 22px);
		border: 2px solid green;
		border-radius: 4px;
		padding: 8px 10px;
		margin: 4px 0px;
		background-color: rgba(0, 249, 12, 0.5);
		display: none;
	}
	.n-conf {
		border-color: red;
		background-color: rgba(255, 0, 4, 0.5);
	}
</style>
</head>

<body>
	<div class="container">
		<div id="sender">
			<input type="text" id="number" placeholder="+923...">
			<div id="recaptcha-container"></div>
			<input type="button" id="send" value="Send" onClick="phoneAuth()">
		</div>
		<div id="verifier" style="display: none">
			<input type="text" id="verificationcode" placeholder="OTP Code">
			<input type="button" id="verify" value="Verify" onClick="codeverify()">
			<div class="p-conf">Number Verified</div>
			<div class="n-conf">OTP ERROR</div>
		</div>
	</div>

	
<!--	add firebase SDK-->
<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>
<script>
	// For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyA4Ez_agCzylwE9gUeDE5GSF5eQsRNC85I",
        authDomain: "shoeshop-project.firebaseapp.com",
        projectId: "shoeshop-project",
        storageBucket: "shoeshop-project.appspot.com",
        messagingSenderId: "229488507707",
        appId: "1:229488507707:web:9acb3c501b75d3ca2a951e",
        measurementId: "G-8M8L95VDVX"
        };

	firebase.initializeApp(firebaseConfig);
render();
function render(){
	window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
	recaptchaVerifier.render();
}
	// function for send message
function phoneAuth(){
	var number = document.getElementById('number').value;
	firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult){
		window.confirmationResult = confirmationResult;
		coderesult = confirmationResult;
		document.getElementById('sender').style.display = 'none';
		document.getElementById('verifier').style.display = 'block';
	}).catch(function(error){
		alert(error.message);
	});
}
	// function for code verify
function codeverify(){
	var code = document.getElementById('verificationcode').value;
	coderesult.confirm(code).then(function(){
		document.getElementsByClassName('p-conf')[0].style.display = 'block';
		document.getElementsByClassName('n-conf')[0].style.display = 'none';
	}).catch(function(){
		document.getElementsByClassName('p-conf')[0].style.display = 'none';
		document.getElementsByClassName('n-conf')[0].style.display = 'block';
	})
}
</script>
</body>
</html>
