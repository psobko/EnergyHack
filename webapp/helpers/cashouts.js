function cashout_sales_part(cashout){
    return _.chain(cashout)
	.pick(cashout,'noofsale','netsales','netsaletax1','netsaletax3','cashpayment','creditpayment','debitpayment','mobilepayment','otherpayment', 'etcpayment')
	.renameKeys('noofsale', 'numberoftransactions',
		    'netsales', 'sales',
		    'netsaletax1', 'tax1',
		    'netsaletax3', 'tax3',
		    'cashpayment', 'cash',
		    'creditpayment', 'credit',
		    'debitpayment', 'debit',
		    'mobilepayment', 'mobile',
		    'otherpayment', 'other',
		    'etcpayment', 'etc')
	//.combine({totalsales:cashout.netsaleactivity})
	.combine({totalsales:Number(toFixed(2)(cashout.netsales + cashout.netsaletax1 + cashout.netsaletax3))})
	.value();
}
function cashout_refund_part(cashout){
    return _.chain(cashout)
	.pick(cashout,'noofrefund','netrefund','netrefundtax1','netrefundtax3','cashrefund','creditrefund','debitrefund','mobilerefund','otherrefund', 'etcrefund')
	.renameKeys('noofrefund', 'numberoftransactions',
		    'netrefund', 'sales',
		    'netrefundtax1', 'tax1',
		    'netrefundtax3', 'tax3',
		    'cashrefund', 'cash',
		    'creditrefund', 'credit',
		    'debitrefund', 'debit',
		    'mobilerefund', 'mobile',
		    'otherrefund', 'other',
		    'etcrefund', 'etc')
	//.combine({totalsales:cashout.netsaleactivity})
	.combine({totalsales:Number(toFixed(2)(cashout.netrefund + cashout.netrefundtax1 + cashout.netrefundtax3))})
	.value();
}
function getSummarySales(cashout){
    var income = cashout_sales_part(cashout);
    var expense = cashout_refund_part(cashout);

    return _.chain(income)
	.subtract(expense)
	.combine({totalsales:cashout.netsaleactivity,
	           numberoftransactions:income.numberoftransactions+expense.numberoftransactions})
	.value();
}
var cashout_total = getSummarySales;
function currency_formatter(summary){
    var currency_format_list = ['cash','credit','debit','mobile','other', 'etc','sales','tax1','tax3','totalsales'];
    var split_curs_non = _(summary).splitKeys(currency_format_list);
    var currency_nums = _.first(split_curs_non);
    var non_cur_nums = _.second(split_curs_non);    // this is numberoftransactions
    _.applyToValues(non_cur_nums,function(obj){
                                 if(_.isNumber(obj)) {
                                    obj = number_with_commas(toNumberFromFormatted(obj));
                                 }
                                 return obj;
                             },true);
    return _.chain(currency_nums)
	.applyToValues(currency_format)
	.combine(non_cur_nums)
	.value();
}