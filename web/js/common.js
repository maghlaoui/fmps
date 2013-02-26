$(document).ready(function() {
    
    $(".pagination li.active").wrapInner("<a href='#'></a>");
    
    $('.popoverInfo').popover({trigger: 'hover'});
    $('.tooltipInfo').tooltip({trigger: 'hover'});
    $('.datepicker').datepicker();
    
    $(".ajax-typeahead").typeahead({
        ajax: {
            displayField: "name",
            triggerLength: 1,
            loadingClass: "loading-circle",
            preProcess: function (data) {
                console.log(data);
                return data;
            },
            onSelect: function (id, val) {
                $("#ArticleIphoneIdMlpArticle").val(id);
                $("#submitButton").removeAttr("disabled");
            }
            
        }
    });
    
    
    /**
    * Fonction qui gère le clique sur les boutons et afficher des modal
    */
    $('.close').on("click", function(){
        $(this).parent().slideUp();
        return false;
    });
     
    /**
     * gérer le slide down et app des formulaire de recherche
     */
    $('#searchHeader').on("click", function(){
        var src = $('#searchArrow').attr('src');
        if($('#searchArrow').attr('alt') == 'down'){
            $('#searchArrow').attr('src', src.replace('arrow_down', 'arrow_up')); 
            $('#searchArrow').attr('alt','up');
        }else{
            $('#searchArrow').attr('src', src.replace('arrow_up', 'arrow_down')); 
            $('#searchArrow').attr('alt','down');
        }
        $('#divSearchForm').slideToggle();
        return false;
    });
    
    /**
    * Fonction qui gère le clique sur les boutons et afficher des modal
    */
    $('.modalbutton').on("click", function(){
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            success: function(msg){
                $('#modal-entities').html(msg);
            },
            error: function(msg){
            },
            beforeSend: function(){
            },
            complete: function(){
                $('#modal-entities').modal('toggle');
            }
        });
        return false;
    }); 

    $('.modalButton').on("click", function(){
	    $(this).modal();
    }); 
    
    /**
     * on gère la pagination et le tri en ajax
     */
    $("#paginationLinks a , #entityList th a").on("click", function(){ 
        reloadList($(this).attr('href'));
        return false;
    });   
    /**
     * fonction qui recharge la liste après les actions (modification, suppression, tri, pagination ...)
     */
    function reloadList(url){
        $.ajax({
            url: url,
            type: 'POST',
            success: function(msg){
                $('#entityList').html(msg);
            },
            beforeSend: function(){
                $('#entityList').html('');
                $('#divLoading').show();
            },
            complete: function(){
                $('#divLoading').hide();
                $(".pagination li.active").wrapInner("<a href='#'></a>");
            }
        });
    	
    }  
    
    
    /**
     * le submit du formulaire de recherche
     */
    $(".entitiySearchForm").on("submit", function(){ 
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                $('#entityList').html(data);
            },
            error: function(data){
				
            },
            beforeSend: function(){
                $('#entityList').html('');
                $('#divLoading').show();
            },
            complete: function(){
                $('#divLoading').hide();
                $(".pagination li.active").wrapInner("<a href='#'></a>");
            }
        });
        return false;
    });
    
    
    /**
     * le submit du formulaire de modification et de l'ajout des utilisateurs
     */
    $(".entityEditForm").on("submit", function(){ 
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serializeArray(),
            success: function(data){
                if(data.message == 'NOK'){
                    $.each(data.errors, function(key, value) { 
                        //nous devons accèder au parent de la div qui entour notre input dont nous avons l'id
                        $('.entityEditForm #'+key).parent().parent().addClass('error');
                        //on affiche le message d'erreur dans le span juste après notre input
                        $('#'+key+'+ .help-block').html(value).show('slow').css("display","block");
                    });
                
                }else if(data.message == 'REDIRECT'){
                    $(location).attr('href',data.location);
                }else{
                    reloadList($('#currentPage').val());
                    $('#modal-entities').modal('toggle');
                    $('#confirmMessage').html(data.messageConfirm);
                    $('#confirmMessageDiv').slideDown(); 
                }
            },
            beforeSend: function(){
                //on masque les message d'erreur
                $('.modal-body .control-group').removeClass("error");
                $('.modal-body .hide').hide();
            },
            complete: function(){

            }
        });
        return false;
    });
    
    
    /**
     * le bouton supprimer
     */
    $("#btnSupprimer").on("click", function(){ 
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            success: function(data){
                $('#modal-entities').modal('toggle');
                $('#confirmMessage').html(data);
                $('#confirmMessageDiv').slideDown();
            },
            complete: function(){
                reloadList($('#currentPage').val());
            }
        });
        return false;
    }); 
    
    /**
     * le bouton supprimer
     */
    $("#changeStatus").on("click", function(){ 
        var btn = $(this);
        $.ajax({
            url: $(this).attr('href')+'/'+btn.attr('data-status'),
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.message == 'FIN'){
                    btn.hide();
                }else{
                    btn.attr('data-status', data.nextStatus);
                }
                $("#statusProgressBar").append(data.progressBar);
                $("#statusLibelle").text(data.statusLibelle);
                $("#ApplicationAppStatut").val(data.status)
            },
            complete: function(){
                
            }
        });
        return false;
    });

	    /**
	     * le submit du formulaire de modification et de l'ajout des utilisateurs
	     */
	    $("#publishBtn").on("click", function(){ 
	    	$.ajax({
	    		url: $(this).attr('href'),
			    type: 'POST',
			    dataType: 'json',
			    success: function(data){
			    	$('#tdStatut_'+data.id).html(data.statut);
			    	$('#button_'+data.id).html(data.button);

			    },
				error: function(data){

			    },
			});
	    	return false;
		});
		
});