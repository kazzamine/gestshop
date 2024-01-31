import '../styles/login.css'

let btnLogin=$('#loginBtn');
let txtUsername=$('#username');
let txtPasswor=$('#password');

btnLogin.on('click',()=>{
    const userData={
        username:txtUsername.val(),
        password:txtPasswor.val()
    }
    fetch('http://gestshop.test/login',
    {
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify(userData)
    })
    .then((Response)=>{
        return Response.json()
    })
    .then((data)=>{
        console.log(data)
    })
})