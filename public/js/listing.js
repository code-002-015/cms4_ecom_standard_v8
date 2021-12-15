let selectedPerPage = $("#displaySize").val();
let perPage = ["10", "25", "50", "75", "100"];
let index = $.inArray(selectedPerPage, perPage);
let selected = (index >= 0) ? index : 0;

$("#displaySize").ionRangeSlider({
    grid: true,
    from: selected,
    values: perPage
});

$('#filter').on('click', function() {
    if (searchType == 'advance_search') {
        window.location.href = advanceListingUrl + "?" + $('#filterForm').serialize() + '&' + $('#advanceFilterForm').serialize();
    } else {
        window.location.href = listingUrl + "?" + $('#filterForm').serialize() + '&' + $('#searchForm').serialize();
    }
});

$('#advanceFilterForm').on('submit', function() {
    window.location.href = advanceListingUrl + "?" + $('#filterForm').serialize() + '&' + $('#advanceFilterForm').serialize();
    return false;
});

$('#searchForm').on('submit', function() {
    window.location.href = listingUrl + "?" + $('#filterForm').serialize() + '&' + $('#searchForm').serialize();
    return false;
});

$('#updated_at1').change(function (){
    $('#updated_at2').attr('min', $(this).val());
});

/*** Handles the Select All Checkbox ***/
$('#checkbox_all').click(function(){
    $('.cb').not(this).prop('checked', this.checked);
    if(this.checked) {
        $('.row_cb').addClass("row-selected");
    }
    else{
        $('.row_cb').removeClass("row-selected");
    }
});

$('.cb').change(function() {
    var id = ($(this).attr('id')).replace("cb", "");
    if(this.checked) {
        $('#row'+id).addClass("row-selected");
    }
    else{
        $('#row'+id).removeClass("row-selected");
    }
});

$('#btnSearch').on('click', function() {
    $('#searchForm').submit();
});
/*** END END Handles the Select All Checkbox END END ***/
