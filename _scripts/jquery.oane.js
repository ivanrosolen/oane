// Plugin for application OANE
(function($){
	$.fn.oane = function(){
		
		data = [{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		}];
		
		objUl = $("#right").find("ul");
		perPage = 4;
		qntdResults = 0;
		
		$.each(data,function(index,element) {
			
			// objects
			objLi = document.createElement("li");
			objTitulo = document.createElement("span");
			objDate = document.createElement("span");
			objImagem = document.createElement("span");
			objDescricao = document.createElement("span");
			objImg = document.createElement("img");
			
			// add new propertie
			$(objImg).attr({"src": element.imagem});
			
			// add class to objects
			$(objTitulo).addClass("titulo").text(element.titulo + ", ");
			$(objDate).addClass("data").text(element.dataEvent);
			$(objDescricao).addClass("descricao").text(element.descricao);
			$(objImagem).addClass("thumb").append(objImg);
			$(objDate).html("added in " + element.dataEvent + "<br>");
			
			$(objLi).append(objImagem).append(objTitulo).append(objDate).append(objDescricao);
			objUl.append(objLi);
			
			if (index > perPage) {
				$(objLi).hide();
			}
			
			qntdResults++;
				
		});
		
		$(".bar-more-results").find("span").each(function(){
			$(this).css({"cursor":"pointer"});
		});
		
		/*
		$(".button-more-results-rec").click(function(){
			atualValueRec = $(this).find("input[type='hidden']").val();
			$(this).find("input[type='hidden']").val(parseInt(atualValueRec-5));
			console.log($(this).find("input[type='hidden']").val());
		});
		*/
		
		$(".button-more-results-rec").hide();
		
		if (qntdResults < 5) {
			$(".button-more-results-ant").hide();
		}
		
		$(".button-more-results-ant").click(function(){
			atualValueAnt = Number($(this).attr("alt"));
			if (Number(atualValueAnt+5) > 0) {
				nextVal = Number(atualValueAnt+5);
				$(this).attr({"alt":nextVal});
				$(".button-more-results-rec").attr({"alt":atualValueAnt});
				$(".button-more-results-rec").show();
				$.fn.oane.popule();
			}
		});
		
		$(".button-more-results-rec").click(function(){
			
			atualValueRec = Number($(".button-more-results-rec").attr("alt"));
			recVal = Number(atualValueRec-5);
			
			if (recVal > 0) {
				$(this).attr({"alt":recVal});
				$(".button-more-results-ant").attr({"alt":Number(recVal+5)});
				$.fn.oane.popule();
				
			} else {
				$(this).attr({"alt":"0"});
				valueAnt = $(".button-more-results-ant").attr("alt");
				$(".button-more-results-ant").attr({"alt":Number(valueAnt-5)});
				$(".button-more-results-rec").attr({"alt":"0"}).hide();
			
			}
			
		});
		
	};
	
	$.fn.oane.resize = function(opts){
		$(opts.parentArea).height($(opts.cloneArea).height());
	};
	
	$.fn.oane.popule = function(opts) {
	
		data = [{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		},{
			titulo : "testando",
			imagem : "_imagens/fota.jpg",
			descricao : "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
			dataEvent : "10.01.2009 10:20:35"
		}];
		
		atualIndexNext = Number($(".button-more-results-ant").attr("alt"));
		atualIndexPrev = Number($(".button-more-results-rec").attr("alt"));
		
		$("#right").find("ul").find("li").hide();
		
		tamanhoArray = data.length;
		
		$.each(data,function(index,element){
			
			if (index >= atualIndexNext) {
				// objects
				objLi = document.createElement("li");
				objTitulo = document.createElement("span");
				objDate = document.createElement("span");
				objImagem = document.createElement("span");
				objDescricao = document.createElement("span");
				objImg = document.createElement("img");
				
				// add new propertie
				$(objImg).attr({"src": element.imagem});
				
				// add class to objects
				$(objTitulo).addClass("titulo").text(element.titulo + ", ");
				$(objDate).addClass("data").text(element.dataEvent);
				$(objDescricao).addClass("descricao").text(element.descricao);
				$(objImagem).addClass("thumb").append(objImg);
				$(objDate).html("added in " + element.dataEvent + "<br>");
				
				$(objLi).append(objImagem).append(objTitulo).append(objDate).append(objDescricao);
				objUl.append(objLi);	
			}
			
		});
	}
	
})(jQuery);

// Code for management data with oane.
jQuery(document).ready(function(){
	$("#geral").oane();
	$("#left").oane.resize({parentArea:"#left", cloneArea:"#right"});
});