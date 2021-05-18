$(document).ready(function(){

				$("#logotipo").on("mouseover", function(){
					 //$("#banner h1").css({"color":"red", "font-size":"12em", "transition":"1s"});
					  $("#banner h1").addClass("efeito");

				}).on("mouseout", function(){

					$("#banner h1").removeClass("efeito");

				});

				$("#busca").on("focus", function(){

					$("li.search").addClass("ativo");

				}).on("blur", function(){

					$("li.search").removeClass("ativo");

				});

				$("#page-up").on("click",function(event){

       	 			$("html,body").animate({
            			scrollTop:0
        			},1000);

        			event.preventDefault();

   				})

				$("#btn-bars").on("click", function(){

					$("header").toggleClass("open-menu");

				})

				$("#menu-mobile-mask, .btn-close").on("click", function(){

					$("header").removeClass("open-menu");

				})

				$("#btn-search").on("click", function(){

					$("header").toggleClass("open-search");
					$("#input-search-mobile").focus();
				})

		});

