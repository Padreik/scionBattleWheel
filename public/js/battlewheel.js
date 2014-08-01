function CategorySelector() {
    var currentCategory = 0;
    var nbOfCategories = $('#caregorySelector').find('option').length;
    var panels = $('#icons > div');
    
    this.first = function() {
        if (currentCategory > 0 && nbOfCategories > 1) {
            change(currentCategory, 0);
            currentCategory = 0;
        }
    }
    
    this.last = function() {
        if (currentCategory < nbOfCategories - 1 && nbOfCategories > 1) {
            change(currentCategory, nbOfCategories - 1);
            currentCategory = nbOfCategories - 1;
        }
    }
    
    this.previous = function() {
        if (currentCategory > 0 && nbOfCategories > 1) {
            change(currentCategory, currentCategory - 1);
            currentCategory--;
        }
    }
    
    this.next = function() {
        if (currentCategory < nbOfCategories - 1 && nbOfCategories > 1) {
            change(currentCategory, currentCategory + 1);
            currentCategory++;
        }
    }
    
    this.move = function(newPosition) {
        if (nbOfCategories > 1 && newPosition < nbOfCategories && newPosition >= 0 && newPosition != currentCategory) {
            change(currentCategory, newPosition);
            currentCategory = newPosition;
        }
    }
    
    var change = function(old, _new) {
        if (old > _new) {
            var hidding = 'right';
            var showing = 'left';
        }
        else {
            var hidding = 'left';
            var showing = 'right';
        }
        $(panels[old]).hide("slide", { direction: hidding }, 400);
        $(panels[_new]).delay(400).show("slide", { direction: showing }, 400);
    }
    
    // Hide all categories
    for (i = 1; i < nbOfCategories; i++) {
        $(panels[i]).hide();
    }
}

categorySelector = new CategorySelector();
$('#firstCategory').click(function() { categorySelector.first(); });
$('#lastCategory').click(function() { categorySelector.last(); });
$('#previousCategory').click(function() { categorySelector.previous(); });
$('#nextCategory').click(function() { categorySelector.next(); });
$('#caregorySelector').change(function(e) { categorySelector.move(this.value); });







$('.icon').click(function() {
    var clone = $(this).clone().appendTo('#floatingIcons');
    clone.css('top', $(this).offset().top + 10);
    clone.css('left', $(this).offset().left + 10);
    clone.draggable({
        create: function(event, ui) {
            $(this).css({
                top: $(this).position().top,
                bottom: "auto"
            });
        }
    });
    clone.find('.close').click(function() {
        this.parentNode.parentNode.removeChild(this.parentNode);
    });
});