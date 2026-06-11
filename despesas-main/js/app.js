const despesaList = []

/**
 * função construtora de objetos despesa
 * @param {*} desc 
 * @param {*} valor 
 */
const Despesa = function (desc="Não informado", valor="0") {
    this.descricao = desc
    this.valor = valor
}

const gerarGrafico = () =>{
    const divGrafico = document.getElementById(`grafico`)
    divGrafico.innerHTML=""
  const ctx = document.createElement("canvas");
  divGrafico.appendChild(ctx)
  const gastoXablaus = despesaList.map(gasto=> gastoLable)
const gastoXablau = despesaList.map(gasto=> gastoValor)
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: gastoXablaus,
      datasets: [{
        label: '# of Votes',
        data: gastoXablau,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });}
/**
 * Cria uma despesa e a adiciona no array
 */
const criarDespesa = () =>{//1.1 Nova despesa no array despesas
    const descricao = document.querySelector("#descricao").value
    const valor = parseFloat(document.querySelector("#valor").value)
    const despesaNova = new Despesa(descricao, valor)
    despesaList.push(despesaNova)
}

const carregarLista = ()=>{//1.2 Adicionar despesa na lista
    
    const lista = document.querySelector("#lista")
    lista.innerHTML = ''
    despesaList.forEach(despesa =>{
        const div = document.createElement("div")
        div.classList.add("item")
        div.textContent = `${despesa.descricao} - R$${despesa.valor}`
        lista.appendChild(div)
    })
    
}

const gerarEstatisticas = () =>{
    const totalDeGasto = despesaList.reduce((atum, despesa) =>{
        return atum + despesa.valor
    }, 0)
    const valores = despesaList.map(despesa => despesa.valor)
    const maiorGasto = Math.max(...valores)
    const menorGasto = Math.min(...valores)
    const media = totalDeGasto / despesaList.length
    const maisCem = despesaList.filter(despesa => despesa.valor > 100)
    const esta = document.querySelector("#estatisticas")
    const dive = document.createElement("div")
    esta.innerHTML= ""
        dive.classList.add("item")
        dive.innerHTML = `Maior gasto: R$${maiorGasto} <br>Menor gasto: R$${menorGasto} <br>Média de gastos: R$${media} <br>Quantidade de gastos acima de R$100: ${maisCem.length} <br>Total gasto: R$${totalDeGasto}`
        esta.appendChild(dive)
        console.log(dive)
}

const btn = document.querySelector("#btnAdicionar")
btn.addEventListener("click", ()=> {//1. Ao clicar no btnAdicionar
    const vale = parseFloat(document.querySelector("#valor").value)
    if(isNaN(vale) == 0 && vale != "" && vale > 0){
    criarDespesa()
    carregarLista()
    gerarEstatisticas()
    gerarGrafico()
}
})

/*
1.3 Gerar estatística
*/