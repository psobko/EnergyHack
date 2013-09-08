function toFixed(mag){
    function roundNumber(rnum, rlength) { // Arguments: number to round, number of decimal places
    var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
    return parseFloat(newnumber); // Output the result to the form field (change for your purposes)
    }
    return function(num){
    if(_.isNumber(num)){
        return roundNumber(num,mag).toFixed(mag);
    }
    return num;
    };
}

function currency_format(num){
    if(_.isNumber(num)){
    return format(",##0.00",toFixed(2)(num));
    }
    return num;
}

function number_with_commas_three_decimal(num){
    if(_.isNumber(num)){
    return format(",##0.000",toFixed(3)(num));
    }
    return num;
}

function number_with_commas(num) {
    if(_.isNumber(num)) {
        var x = toFixed(0)(Number(num));
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");    
    }
    return num;    
}

function toNumberFromFormatted(input) {
    if(_.isNumber(input) && !_.isNaN(input)) {
        return input;
    } else if(!_.isNaN(Number(input))) {
        return Number(input);
    } else {
        var tmp = Number(_.str.trim(input.toString().replace(/,/g,"").replace(/\$/g,"")));
        if(_.isNaN(tmp)) {
            return input;
        } else {
            return tmp;
        }
    }
}
