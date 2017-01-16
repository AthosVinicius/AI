<?php
/**
 * Created by PhpStorm.
 * User: Athos Vinicius
 * Date: 11/01/2017
 * Time: 10:43
 */
?>

<html>
    <head>
        <title>AI - learnig Machine</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <script>

            var modelo = [8,4,4,8,8,2,2,1,9,9];
            var indiv = 10;
            var geno = 10;
            var geracoes = 1000;
            var selecionados = 2;
            var chance_de_mutacao = 0.3;

            window.onload = function(){

                var geracao = criarPopulacao(1,9);
                resultados(geracao);
                console.log("inicial");

                for(var i = 0; i < geracoes; i++) {
                    geracao = gerarFitness(geracao);

                    var pais = selecionarPais(geracao);

                    geracao = crossover_e_reproducao(pais);
                    geracao = mutacao(geracao);
                }


                resultados(geracao);
            }


            function gerarNRandom(min, max){

                return Math.floor(Math.random() * (max - min + 1) + min);

            }
            function randOrd() {
                return (Math.round(Math.random())-0.5);
            }
            function copiarObj(original) {
                var copia = (original instanceof Array) ? [] : {}; // verificando se é um array ou um objeto 'comum' e instanciando a cópia
                for (i in original) { // iterando cada propriedade do objeto original
                    if (original[i] && typeof original[i] == 'object') copia[i] = copiarObj(original[i]); // se for um objeto realiza cópia desse objeto (note a recursividade aqui)
                    else copia[i] = original[i]; // se não simplesmente copia o valor
                }
                return copia; // retorna a cópia
            };



            function criarPopulacao(min, max) {

                var populacao = [];
                var individuo = [];

                for (var i = 0; i < indiv; i++) {

                    individuo = [];

                    for (var n = 0; n < geno; n++) {

                        individuo[n] = gerarNRandom(min, max);
                    }

                    populacao[i] = individuo;
                }

                return populacao;
            }
            function gerarFitness(populacao){

                var arrayPopulacao = [];
                var fitness = 0;
                var individual = [];

                for (var i = 0; i < (populacao.length); i++) {

                    fitness = 0;
                    individual = populacao[i];

                    for (var n = 0; n < (individual.length); n++) {
                        if (individual[n] == modelo[n]) {
                            fitness += 1
                        }

                    }

                    arrayPopulacao[i] = [fitness, individual];
                }


                return arrayPopulacao;
            }
            function selecionarPais(populacao){

                var ArrayOrdenado = populacao.slice(0);
                var ArrayPais = [];
                ArrayOrdenado.sort();

                for(var i = (ArrayOrdenado.length - selecionados); i< ArrayOrdenado.length; i++){

                    ArrayPais.push(ArrayOrdenado[i]);

                }


                return ArrayPais;

            }
            function crossover_e_reproducao(pais){

                var PaiModelo = [];
                var NovaGeracao = [];
                var ponto = 0;
                var ponto2 = 0;
                var valor = 0;

                //Elimina a pontuação fitness do individuo
                for(var i = 0; i< pais.length; i++) {
                    pais[i] = pais[i][1];
                }

                //Seleciona o pai modelo
                PaiModelo = pais[(pais.length-1)];

                //realiza a cossover
                var vx = 0;
                for(var i = 0; i< indiv; i++) {

                    if(vx == pais.length){
                        vx = 0;
                    }

                    for(var n = 0; n< 2; n++) {

                        ponto2 = gerarNRandom(1, 9);
                        ponto = gerarNRandom(1, 9);

                        valor = PaiModelo[ponto];

                        pais[vx][ponto2] = valor;
                    }

                    NovaGeracao[i] = copiarObj(pais[vx]);

                    vx++;

                }

                return NovaGeracao;
            }
            function mutacao(population) {

                for(var i = 0; i < (population.length - 3); i++){

                    if(Math.random() <= chance_de_mutacao){

                        var punto = gerarNRandom(0, 9);
                        var nuevo_valor = gerarNRandom(1, 9);

                        while (nuevo_valor == population[i][punto]){
                            nuevo_valor = gerarNRandom(1, 9);
                        }

                        population[i][punto] = nuevo_valor;

                    }
                }


                return population;

            }
            function resultados(geracao){



                //RESULTADOS

                var arrayPopulacao = [];
                var fitness = 0;
                var individual = [];

                for (var i = 0; i < (geracao.length); i++) {

                    fitness = 0;
                    individual = geracao[i];

                    for (var n = 0; n < (individual.length); n++) {
                        if (individual[n] == modelo[n]) {
                            fitness += 1
                        }

                    }

                    arrayPopulacao[i] = [fitness, individual];
                }


                arrayPopulacao.sort();

                console.log("MODELO: "+modelo);
                console.log("===============");
                for(var i = (arrayPopulacao.length-3); i< arrayPopulacao.length; i++){

                    console.log("Resultado "+i+": PRECISÃO ["+(arrayPopulacao[i][0]*10)+"%] "+arrayPopulacao[i][1]);
                }

            }


        </script>
    </head>
    <body>

        <span id="resultado"></span>


    </body>
</html>
