
Date.prototype.toArray = function(){
    return [this.getFullYear(),
	    (this.getMonth()+1),
	    this.getDate(),
	    this.getHours(),
	    this.getMinutes(),
	    this.getSeconds()];
};

function updateDate() {
      var ts = $("#timespace");
      $(document).everyTime("1s", function(){
      var date = new Date();
      ts.empty();
      ts.append(date.toDateString() + " / " + date.toLocaleTimeString());
      }, 0);
};

function doc_setup() {
	updateDate();
    var urlBase = window.location.protocol + "//" + window.location.hostname + ":" +window.location.port + "/";
    
    (new (Backbone.Router.extend(
	  {routes: {
	       "":"setup"
	   },
	   menu_options:{
	       sales_summay:{title:'Sales Summary',link:'sales_summary',img:'salessummary.png'},
	       sales_details:{title:'Sales Detail',link:'sales_details',img:'salesdetails.png'},
	       how_are_we_doing_today:{title:'How Are We Doing Today',link:'how_are_we_doing_today',img:'howarewedoingtoday.png'},
	       hourly_activity:{img:"hourlyactivity.png",title:'Hourly Activity',link:'hourly_activity'},
	       electronic_payments_summary:{img:'epayment.png',title:'Electronic Payments Summary',link:'electronic_payments_summary'},
	       electronic_payments_history:{img:'epayment.png',title:'Electronic Payments History',link:'electronic_payments_history'},
	       tax_collected:{img:'tax.png',title:'Tax Collected',link:'tax_collected'},
	       cash_outs:{img:'cashouts.png',title:'Cash Outs',link:'cash_outs'},
	       transactions_detail:{img:'transactionsdetails.png',title:'Transactions Detail',link:'transactions_detail'},
	       cancelled_transactions:{img:'cancelledtransactions.png',title:'Cancelled Transactions',link:'cancelled_transactions'},
	       refunds:{img:'refunds.png',title:'Refunds Transactions',link:'refunds'},
	       discounts:{img:'discounts.png',title:'Discounts Transactions',link:'discounts'},
	       voucher_history:{img:"voucherhistory.png",title:'Voucher Transactions',link:'voucher_transactions'},
	       payout:{img:"payout.png",title:'Payout Transactions',link:'payout_transactions'},
	       loadcard:{img:"voucheractivity.png",title:'Voucher Activity',link:'voucher_activity'},
	       voucher_outstanding:{img:"voucheroutstanding.png",title:'Voucher Outstanding',link:'voucher_outstanding'}
	   },
	   render:function(template_data){
	   		var model = new (Backbone.Model.extend());
	       var html = ich.report_TMP({title:"Hello, User"});
	       $("#main").html(html);
	   },
	   setup: function() {
	   		var router = this;
	   		router.render();
		   	// multimethod()
		   // .dispatch(function(){
				 // return topLevelEntity(ReportData).type;
			     // })
		   // .when('company',function(){
			     // var options_list = _.toArray(this.menu_options);
			     // var template_data = _.extend(autoBreadCrumb(),{options:options_list});
			     // this.render(template_data);
			 // })
		   // .when('group',function(){
			     // var options_list = _.chain(this.menu_options).removeKeys('voucher_history', 'loadcard', 'voucher_outstanding').toArray().value();
			     // var template_data = _.extend(autoBreadCrumb(),{options:options_list});
			     // this.render(template_data);
			 // })
		   // .when('store',function(){
			     // var options_list = _.chain(this.menu_options).removeKeys('voucher_history', 'loadcard', 'voucher_outstanding').toArray().value();
			     // var template_data = _.extend(autoBreadCrumb(),{options:options_list});
			     // this.render(template_data);
			 // });
	   }
	   
	  })));
    
    
    Backbone.history.start();

	$("#layeredloginpassword").keyup(function(event){
  		if(event.keyCode == 13){
	    login();
	  }
	});
};

$(document)
    .ready(function() {
	       //this is for IE7
	       if(_.isUndefined(window.console)){
		      console = {log:function(){/*do nothing*/}};
	       }
           if (!window.location.origin){
              window.location.origin = window.location.protocol+"//"+window.location.host;
           }
	       doc_setup();
	   });
