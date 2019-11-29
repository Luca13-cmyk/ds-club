(function(){

    //  ##################### AJAX ######################

var AZ = document.getElementById("ajaxAZ");
var ajaxAZsubmit = document.getElementById("ajaxAZsubmit");
var valueAJAXAZ = document.getElementById("valueAJAXAZ");
var statusAZ = document.getElementById("statusAZ");

if (AZ && ajaxAZsubmit)
  {

    ajaxAZsubmit.addEventListener("submit", function(e){


      e.preventDefault();
      var value = valueAJAXAZ.value;

      if (value == "") return;
      if (value.length > 1) return;

      AZ.innerHTML = ""; // limpa o historico, para n acumular requisicoes.
      var xhr = new XMLHttpRequest(); // faz a requisicao.
      
      
        xhr.onload = function()
  
        {
          //######## testes
          // console.log(xhr.response.length);
          // console.log(xhr.response);
          // response = xhr.response;
          // #######
          
          if (xhr.status === 200)
          {
            try {
              statusAZ.style.display = "none";
              responseObject = JSON.parse(xhr.responseText);
              
              const r = responseObject;
              console.table(r);
              
              
              
              // Quantidade de visualizacoes
              // document.querySelector("p[data-nqnt]").innerHTML = "Atual: " + r[1];

              // Ultima atualizacao
              // var d = new Date();
              // document.querySelector("i[data-update-per-visitas]").innerHTML = " Ultima atualizacao:  " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

              
              

              // Execucao no content
              

              for (let index = 0; index < r.length; index++) {
                
                AZ.innerHTML +=  "<a href='/topics/" + r[index].idtopic + "'><li class='list-group-item'>" +  r[index].destopic  + "</li></a>"; 
                
            
              }
              
              
            
            } catch (error) {
                statusAZ.style.display = "block";
                statusAZ.innerHTML = "<small>Nao foi possivel concluir a busca. Tente novamente.</small>";
              
            }
            
          } else 
          {
            statusAZ.style.display = "block";
            statusAZ.innerHTML = "<small>Nao foi possivel concluir a busca. Tente novamente.</small>";
          }
          
          
  
        }

        
      xhr.open("GET", "https://lds-club-com.umbler.net/data/ajax/AZ?l=" + value, true);
      xhr.send(null);




    }, false); // evento ajax para atualizar.
    
      
  }




}());