document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("checkoutForm");

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Valores
    let nome = document.getElementById("nome").value.trim();
    let dataNascimento = document.getElementById("data_nascimento").value;
    let morada = document.getElementById("morada_entrega").value.trim();

    // Verifica se os campos estão vazios
    if (nome === "") {
      alert("Nome obrigatório");
    }

    if (dataNascimento === "") {
      alert("Data de Nascimento obrigatório");
    }

    if (morada === "") {
      alert("Morada obrigatório");
    }

    // Validar a idade
    if (dataNascimento !== "") {
      let hoje = new Date();
      let nascimento = new Date(dataNascimento);
      let idade = hoje.getFullYear() - nascimento.getFullYear();

      if (idade < 18) {
        alert("Deve ter pelo menos 18 anos para concluir a compra");
      }
    }

    form.submit();
  });
});
