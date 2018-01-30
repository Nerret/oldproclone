/**
 * Created by ande738e on 24-05-2016.
 */
$(document).ready(function () {
    $('.buttonModal').click(function (e) {
        
        
        $('.modal-title').html('');
        $('.modal-dato').html('');
        $('.modal-tod').html('');
        $('.modal-loc').html('');
        $('.modal-eventtype').html('');
        $('.modal-sum').html('');
        $('.modal-notickets').html('');
        
        
       
        var dataId = $(this).attr('data-id');
        var jumpBox = $('.jump-box[data-parentid=' + dataId + ']');
        var titel = jumpBox.find('.jump-title');
        console.log(titel[0].innerText);
        var dato = jumpBox.find('.jump-dato');
        var loc = jumpBox.find('.jump-loc');
        var eventtype = jumpBox.find('.jump-eventtype');
        var tod = jumpBox.find('.jump-tod');
        var sum = jumpBox.find('.jump-sum');
        var notickets = jumpBox.find('.jump-notickets');


        $('.modal-title').append(titel[0].innerText);
        $('.modal-dato').append(dato[0].innerText);
        $('.modal-tod').append(tod[0].innerText);
        $('.modal-loc').append(loc[0].innerText);
        $('.modal-eventtype').append(eventtype[0].innerText);
        $('.modal-sum').append(sum[0].innerText);
        $('.modal-notickets').append(notickets[0].innerText);

    });
});

