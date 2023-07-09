//obtengo los elementos del html por su id y obtengo su valor para obtener numero
//especie perro
var especieperro = document.getElementById("especiesgraphicdog");
var especieperro = especieperro.textContent;
var especieperro = especieperro.split(' ').pop();

//especie gato
var especiegato = document.getElementById("especiesgraphiccat");
var especiegato = especiegato.textContent;
var especiegato = especiegato.split(' ').pop();

//especie conejo
var especieconejo = document.getElementById("especiesgraphicbunny");
var especieconejo = especieconejo.textContent;
var especieconejo = especieconejo.split(' ').pop();

//especie hamster
var especiehamster = document.getElementById("especiesgraphichamster");
var especiehamster = especiehamster.textContent;
var especiehamster = especiehamster.split(' ').pop();

//especie serpiente
var especieserpiente = document.getElementById("especiesgraphicsnake");
var especieserpiente = especieserpiente.textContent;
var especieserpiente = especieserpiente.split(' ').pop();

//especie perro
var especietortuga = document.getElementById("especiesgraphicturthe");
var especietortuga = especietortuga.textContent;
var especietortuga = especietortuga.split(' ').pop();

//especie otro
var especiegotro = document.getElementById("especiesgraphicother");
var especiegotro = especiegotro.textContent;
var especiegotro = especiegotro.split(' ').pop();

//Creo array valores de la grafica especie (x,y) y color
var xValues = ["Perro/Dog", "Gato/Cat", "Conejo/Bunny", "Hamster", "Serpiente/Snake","Tortuga/Tortoise","Otro/Other"];
var yValues = [especieperro, especiegato, especieconejo, especiehamster, especieserpiente,especietortuga,especiegotro];
var barColors = ["red", "purple","blue","orange","brown", "palevioletred","green"];

//Creo gráfica especie
new Chart("ChartSpecies", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: false,
    },
    scales: {
            xAxes: [{
                ticks: {
                    display: false //this will remove only the label
                }
            }]
        }
  }
});

//obtengo los elementos del html por su id y obtengo su valor para obtener numero
//genero hombre
var generohombre = document.getElementById("gendergraphichombre");
var generohombre = generohombre.textContent;
var generohombre = generohombre.split(' ').pop();

//genero mujer
var generomujer = document.getElementById("gendergraphicmujer");
var generomujer = generomujer.textContent;
var generomujer = generomujer.split(' ').pop();

//genero no binario
var generonobinario = document.getElementById("gendergraphicnobinario");
var generonobinario = generonobinario.textContent;
var generonobinario = generonobinario.split(' ').pop();

//genero otro
var generootro = document.getElementById("gendergraphicotro");
var generootro = generootro.textContent;
var generootro = generootro.split(' ').pop();

//Creo array valores de la grafica genero (x,y) y color
var xValues = ["Hombre/Man", "Mujer/Woman", "No binario/No binary", "Otro/Other"];
var yValues = [generohombre, generomujer, generonobinario, generootro];
var barColors = ["red", "purple","blue","orange"];

//Creo gráfica
new Chart("ChartGender", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: false,
    },
    scales: {
            xAxes: [{
                ticks: {
                    display: false //this will remove only the label
                }
            }]
        }
  }
});

//obtengo los elementos del html por su id y obtengo su valor para obtener numero
//edad -30
var menostreinta = document.getElementById("edadgraphicmenostreinta");
var menostreinta = menostreinta.textContent;
var menostreinta = menostreinta.split(' ').pop();

//edad +30 y -60
var entretreintaysesenta = document.getElementById("edadgraphictreintasesenta");
var entretreintaysesenta = entretreintaysesenta.textContent;
var entretreintaysesenta = entretreintaysesenta.split(' ').pop();

//edad +60
var agemassesenta = document.getElementById("edadgraphicmenosmassesenta");
var agemassesenta = agemassesenta.textContent;
var agemassesenta = agemassesenta.split(' ').pop();

//Creo array valores de la grafica edad (x,y) y color
var xValues = ["-30", "30-60", "+60"];
var yValues = [menostreinta, entretreintaysesenta, agemassesenta];
var barColors = ["red", "purple","blue"];

//Creo gráfica edad
new Chart("ChartAge", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: false,
    },
    scales: {
            xAxes: [{
                ticks: {
                    display: false //this will remove only the label
                }
            }]
        }
  }
});

//obtengo los elementos del html por su id y obtengo su valor para obtener numero
//sin hijos
var nohhijo = document.getElementById("hijosgraphicno");
var nohhijo = nohhijo.textContent;
var nohhijo = nohhijo.split(' ').pop();

//un hijo
var unhijo = document.getElementById("hijosgraphicuno");
var unhijo = unhijo.textContent;
var unhijo = unhijo.split(' ').pop();

//dos hijos
var doshijo = document.getElementById("hijosgraphicdos");
var doshijo = doshijo.textContent;
var doshijo = doshijo.split(' ').pop();

//mas de dos hijos
var masdoshijo = document.getElementById("hijosgraphicmasdos");
var masdoshijo = masdoshijo.textContent;
var masdoshijo = masdoshijo.split(' ').pop();

//Creo array valores de la grafica numero de hijos (x,y) y color
var xValues = ["0","1", "2", "+2"];
var yValues = [nohhijo, unhijo, doshijo,masdoshijo];
var barColors = ["red", "purple","blue","orange"];

//Creo gráfica hijos
new Chart("ChartChildren", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: false,
    },
    scales: {
            xAxes: [{
                ticks: {
                    display: false //this will remove only the label
                }
            }]
        }
  }
});