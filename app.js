document.querySelector('#form').addEventListener('submit', function(e) {

    e.preventDefault();

    const formData = new FormData(this);

    fetch('process.php', {
        method:'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.convertedAmount) {

           document.querySelector('#convertedAmount').value = data.convertedAmount;
        } else {

            console.log('Algo deu errado')
        }
})

})
