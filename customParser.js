

var OPENTAG_IB = "<ns2:IntervalBlock>";
var CLOSETAG_IB = "</ns2:IntervalBlock>";

var OPENTAG_INT = "<ns2:interval>";
var CLOSETAG_INT = "</ns2:interval>";

var OPENTAG_DUR = "<ns2:duration>";
var CLOSETAG_DUR = "</ns2:duration>";

var OPENTAG_ST = "<ns2:start>";
var CLOSETAG_ST = "</ns2:start>";

var OPENTAG_IR = "<ns2:IntervalReading>";
var CLOSETAG_IR = "</ns2:IntervalReading>";

var OPENTAG_CO = "<ns2:cost>";
var CLOSETAG_CO = "</ns2:cost>";

var OPENTAG_TP = "<ns2:timePeriod>";
var CLOSETAG_TP = "</ns2:timePeriod>";

var OPENTAG_VAL = "<ns2:value>";
var CLOSETAG_VAL = "</ns2:value>";



function parseCustomGreenButtonXML(stringXML) {
	var strXML = stringXML;
	var listJson = [];
	
	var done = false;

	while(!done) {
		var index_begin = strXML.indexOf(OPENTAG_IB);
		var index_end = strXML.indexOf(CLOSETAG_IB);
		
		if(index_begin<0) {
			done = true;
		} else {
			var strIB = strXML.substring((index_begin+OPENTAG_IB.length),index_end);
			var newIB = {
				interval : undefined,
				intervalReading : []
			};
			
			var start_INT = strIB.indexOf(OPENTAG_INT);
			var end_INT = strIB.indexOf(CLOSETAG_INT);
			var strINT = strIB.substring((start_INT+OPENTAG_INT.length),end_INT);
			var newINT = {
				duration : 0,
				start : 0
			};
			
			var start_DUR = strINT.indexOf(OPENTAG_DUR);
			var end_DUR = strINT.indexOf(CLOSETAG_DUR);
			var strDUR = strINT.substring((start_DUR+OPENTAG_DUR.length),end_DUR);
			var duration_interval = Number(strDUR);
			
			var start_ST = strINT.indexOf(OPENTAG_ST);
			var end_ST = strINT.indexOf(CLOSETAG_ST);
			var strST = strINT.substring((start_ST+OPENTAG_ST.length),end_ST);
			var start_interval = Number(strST);
			
			newINT.duration = duration_interval;
			newINT.start = start_interval;
			
			newIB.interval = newINT;
			
			var done2 = false;
	
			while(!done2) {
				var start_IR = strIB.indexOf(OPENTAG_IR);
				var end_IR = strIB.indexOf(CLOSETAG_IR);
				
				if(start_IR<0) {
					done2 = true;
				} else {
					var strIR = strIB.substring((start_IR+OPENTAG_IR.length),end_IR);
					var newIR = {
						cost : 0,
						timePeriod : undefined,
						value : 0
					};
					
					var start_CO = strIR.indexOf(OPENTAG_CO);
					var end_CO = strIR.indexOf(CLOSETAG_CO);
					var strCO = strIR.substring((start_CO+OPENTAG_CO.length),end_CO);
					var cost = Number(strCO);
					
					var start_VAL = strIR.indexOf(OPENTAG_VAL);
					var end_VAL = strIR.indexOf(CLOSETAG_VAL);
					var strVAL = strIR.substring((start_VAL+OPENTAG_VAL.length),end_VAL);
					var value = Number(strVAL);
					
					var start_TP = strIR.indexOf(OPENTAG_TP);
					var end_TP = strIR.indexOf(CLOSETAG_TP);
					var strTP = strIR.substring((start_TP+OPENTAG_TP.length),end_TP);
					var newTP = {
						duration : undefined,
						start : undefined
					};
					
					var start_DUR2 = strTP.indexOf(OPENTAG_DUR);
					var end_DUR2 = strTP.indexOf(CLOSETAG_DUR);
					var strDUR2 = strTP.substring((start_DUR2+OPENTAG_DUR.length),end_DUR2);
					var duration_intervalreading = Number(strDUR2);
					
					var start_ST2 = strTP.indexOf(OPENTAG_ST);
					var end_ST2 = strTP.indexOf(CLOSETAG_ST);
					var strST2 = strTP.substring((start_ST2+OPENTAG_ST.length),end_ST2);
					var start_intervalreading = Number(strST2);
					
					newTP.duration = duration_intervalreading;
					newTP.start = start_intervalreading;
					
					newIR.cost = cost;
					newIR.timePeriod = newTP;
					newIR.value = value;
					
					newIB.intervalReading = newIB.intervalReading.concat(newIR);
					
					strIB = strIB.substr(end_IR+CLOSETAG_IR.length);
				}
			}
			
			listJson = listJson.concat(newIB);
					
			strXML = strXML.substr(index_end+CLOSETAG_IB.length);
			
		}
	}
	
	return listJson;
}

function parseCustomGreenButtonXML_filled(stringXML) {
	var listJson = parseCustomGreenButtonXML(stringXML);
	
	var newListJson = _.map(listJson, function(intervalBlock) {
		var newIntervalReading = [intervalBlock.intervalReading[0]];
		var prevIntervalReading = undefined;
		for(var i=1; i<24; i++) {
			if(newIntervalReading[i-1]!=undefined) {
				prevIntervalReading = newIntervalReading[i-1];
			}
			
			if(intervalBlock.intervalReading[i]==undefined || intervalBlock.intervalReading[i].timePeriod.start != (prevIntervalReading.timePeriod.start + prevIntervalReading.timePeriod.duration) ) {
				var fakeIntervalReading = {
					cost : prevIntervalReading.cost,
					value : prevIntervalReading.value,
					timePeriod : {
						duration : prevIntervalReading.timePeriod.duration,
						start : (prevIntervalReading.timePeriod.duration + prevIntervalReading.timePeriod.start)
					}
				};
				newIntervalReading = newIntervalReading.concat(fakeIntervalReading);
			} else {
				newIntervalReading = newIntervalReading.concat(intervalBlock.intervalReading[i]);
			}
		}
		
		intervalBlock.intervalReading = newIntervalReading;
		return intervalBlock;
	});
	
	return newListJson;
}

function parseCustomGreenButtonXML_filled_formatted(stringXML) {
	var listJson = parseCustomGreenButtonXML_filled(stringXML);
	
	var newListJson = _(listJson).chain()
						.map(function(intervalBlock) {
							return intervalBlock.intervalReading;
						})
						.flatten()
						.map(function(intervalReading) {
							var item = {
								cost : (intervalReading.cost / 100000),
								value : (intervalReading.value / 100000),
								time : intervalReading.timePeriod.start  //((new Date(intervalReading.timePeriod.start*1000)).format("yyyy-mm-dd hh:MM:ss"))
							};
							
							return item;
						})
						.value();
	
	return newListJson;
}

function postData_F(item) {
	return function(callback) {
		var url = "http://marsenergyhack.nfshost.com/GreenButtonProject/EnergyHack/api/parsecallback.php";
		
		var strQ = "cost=".concat(item.cost).concat("&value=").concat(item.value).concat("&time=").concat(item.time);
		
		url = url.concat("?").concat(strQ);
		$.ajax({
			type: "POST",
			contentType:"json",
			data:"",
			url: url,
			success: function() {
			    callback(undefined, true);
			},
			error:function() {
			    callback(true, arguments);
			}
		});		
	};
}

var listF = _.map(list, function(item) {
	return postData_F(item);
});

async.parellel(
	listF,
	function(err, result) {
		console.log(arguments);
	}
)
