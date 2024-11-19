

document.getElementById('form-cadastro').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    const dados = {
        nome: nome,
        email: email,
        senha: senha
    };

    fetch('cadastro.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json()) 
    .then(data => {
        alert(data.message);
    })
    .catch(error => {
        console.error('Erro ao cadastrar:', error);
        alert('Erro ao cadastrar o usuário.');
    });
});
