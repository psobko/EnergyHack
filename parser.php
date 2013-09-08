<?php
// phpinfo();exit;
// define('BASEURL','https://greenbutton.affsys.com');
// echo BASEURL."/ldc/api/v1/UsagePoint?start=1378353600&duration=86400";exit;
// $content = requestURL("https://greenbutton.affsys.com/ldc/api/v1/UsagePoint?start=1378353600&duration=86400");
// echo '<pre>';print_r($content);echo '</pre>';
$xmlstring = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:ns2="http://naesb.org/espi"
	xmlns:ns3="http://gov.on.ca/espi">
	<id>urn:uuid:3a64953f-ce22-4cfc-a0fc-6f865ba8d6c8</id>
	<title>ThirdParty Test Batch Feed</title>
	<updated>2013-09-07T21:02:28Z</updated>
	<link href="/ThirdParty/4/Batch" rel="self" />
	<entry>
		<id>urn:uuid:fca01b1b-d903-11e2-884a-00155d003900</id>
		<link href="/User/1/UsagePoint/1" rel="self" />
		<link href="/User/1/UsagePoint" rel="up" />
		<link href="/User/1/UsagePoint/1/MeterReading" rel="related" />
		<link href="/LocalTimeParameters/2" rel="related" />
		<title>99344 South Durango Way, Milton, L9H 3R5</title>
		<content>
			<ns2:UsagePoint>
				<ns2:ServiceCategory>
					<ns2:kind>0</ns2:kind>
				</ns2:ServiceCategory>
			</ns2:UsagePoint>
		</content>
		<published>2013-09-07T21:02:28Z</published>
		<updated>2013-09-07T21:02:28Z</updated>
	</entry>
	<entry>
		<id>urn:uuid:56e09b17-9762-4d93-9f88-98f5417d4796</id>
		<link href="/LocalTimeParameters/2" rel="self" />
		<link href="/LocalTimeParameters" rel="up" />
		<title>North America - Eastern Time Zone</title>
		<content>
			<ns2:LocalTimeParameters>
				<ns2:dstEndRule>B40E2000</ns2:dstEndRule>
				<ns2:dstOffset>3600</ns2:dstOffset>
				<ns2:dstStartRule>360E2000</ns2:dstStartRule>
				<ns2:tzOffset>-18000</ns2:tzOffset>
			</ns2:LocalTimeParameters>
		</content>
		<published>2013-09-07T21:02:28Z</published>
		<updated>2013-09-07T21:02:28Z</updated>
	</entry>
	<entry>
		<id>urn:uuid:ebc8c6ea-5d45-49a6-8e2b-546f571ab1a4</id>
		<link href="/User/1/UsagePoint/1/MeterReading/01" rel="self" />
		<link href="/User/1/UsagePoint/1/MeterReading" rel="up" />
		<link href="/User/1/UsagePoint/1/MeterReading/01/IntervalBlock"
			rel="related" />
		<link href="/ReadingType/07" rel="related" />
		<title>Hourly Electricity Consumption</title>
		<content>
			<ns2:MeterReading />
		</content>
		<published>2013-09-07T21:02:28Z</published>
		<updated>2013-09-07T21:02:28Z</updated>
	</entry>
	<entry>
		<id>urn:uuid:ecaef8db-1991-4d4f-8ce1-0728a6cda50f</id>
		<link href="/User/1/UsagePoint/1/MeterReading/01/IntervalBlock/0173"
			rel="self" />
		<link href="/User/1/UsagePoint/1/MeterReading/01/IntervalBlock"
			rel="up" />
		<title></title>
		<content>
			<ns2:IntervalBlock>
				<ns2:interval>
					<ns2:duration>86400</ns2:duration>
					<ns2:start>1378008000</ns2:start>
				</ns2:interval>
				<ns2:IntervalReading>
					<ns2:cost>43170</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378008000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>4151</ns2:value>
				</ns2:IntervalReading>
			</ns2:IntervalBlock>
			<ns2:IntervalBlock>
				<ns2:interval>
					<ns2:duration>86400</ns2:duration>
					<ns2:start>1378267200</ns2:start>
				</ns2:interval>
				<ns2:IntervalReading>
					<ns2:cost>14799</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378339200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1423</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>35370</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378342800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3401</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>39873</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378346400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3834</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>46456</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378350000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>4467</ns2:value>
				</ns2:IntervalReading>
			</ns2:IntervalBlock>
			<ns2:IntervalBlock>
				<ns2:interval>
					<ns2:duration>86400</ns2:duration>
					<ns2:start>1378353600</ns2:start>
				</ns2:interval>
				<ns2:IntervalReading>
					<ns2:cost>20134</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378353600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1936</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>6011</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378357200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>578</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>14372</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378360800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1382</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>7020</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378364400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>675</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>36743</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378368000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3533</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>24315</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378371600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2338</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>10296</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378375200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>990</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>23285</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378378800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2239</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>38750</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378382400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3726</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>31335</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378386000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3013</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>39384</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378389600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3787</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>10389</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378393200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>999</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>24252</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378396800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2332</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>43295</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378400400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>4163</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>5397</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378404000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>519</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>33363</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378407600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3208</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>12313</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378411200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1184</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>6177</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378414800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>594</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>38677</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378418400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3719</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>36545</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378422000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3514</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>21860</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378425600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2102</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>26249</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378429200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2524</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>18876</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378432800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1815</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>14601</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378436400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1404</ns2:value>
				</ns2:IntervalReading>
			</ns2:IntervalBlock>
			<ns2:IntervalBlock>
				<ns2:interval>
					<ns2:duration>86400</ns2:duration>
					<ns2:start>1378440000</ns2:start>
				</ns2:interval>
				<ns2:IntervalReading>
					<ns2:cost>15350</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378440000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1476</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>31917</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378443600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3069</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>20966</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378447200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2016</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>8060</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378450800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>775</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>22110</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378454400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2126</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>39561</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378458000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3804</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>38948</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378461600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3745</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>29234</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378465200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2811</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>28329</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378468800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2724</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>7124</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378472400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>685</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>41111</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378476000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3953</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>45874</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378479600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>4411</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>13478</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378483200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1296</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>20248</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378486800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1947</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>14029</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378490400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1349</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>8372</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378494000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>805</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>44501</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378497600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>4279</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>13301</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378501200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>1279</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>23472</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378504800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2257</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>30680</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378508400</ns2:start>
					</ns2:timePeriod>
					<ns2:value>2950</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>36171</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378512000</ns2:start>
					</ns2:timePeriod>
					<ns2:value>3478</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>42026</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378515600</ns2:start>
					</ns2:timePeriod>
					<ns2:value>4041</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>9058</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378519200</ns2:start>
					</ns2:timePeriod>
					<ns2:value>871</ns2:value>
				</ns2:IntervalReading>
				<ns2:IntervalReading>
					<ns2:cost>9682</ns2:cost>
					<ns2:timePeriod>
						<ns2:duration>3600</ns2:duration>
						<ns2:start>1378522800</ns2:start>
					</ns2:timePeriod>
					<ns2:value>931</ns2:value>
				</ns2:IntervalReading>
			</ns2:IntervalBlock>
		</content>
		<published>2013-09-07T21:02:28Z</published>
		<updated>2013-09-07T21:02:28Z</updated>
	</entry>
	<entry>
		<id>urn:uuid:59036626-4272-49e9-a2e3-a6b3bf30796d</id>
		<link href="/ReadingType/07" rel="self" />
		<link href="/ReadingType" rel="up" />
		<title>Energy Delivered (kWh)</title>
		<content>
			<ns2:ReadingType>
				<ns2:accumulationBehaviour>4</ns2:accumulationBehaviour>
				<ns2:commodity>1</ns2:commodity>
				<ns2:currency>124</ns2:currency>
				<ns2:dataQualifier>12</ns2:dataQualifier>
				<ns2:flowDirection>1</ns2:flowDirection>
				<ns2:intervalLength>3600</ns2:intervalLength>
				<ns2:kind>12</ns2:kind>
				<ns2:phase>0</ns2:phase>
				<ns2:powerOfTenMultiplier>0</ns2:powerOfTenMultiplier>
				<ns2:timeAttribute>0</ns2:timeAttribute>
				<ns2:uom>72</ns2:uom>
			</ns2:ReadingType>
		</content>
		<published>2013-09-07T21:02:28Z</published>
		<updated>2013-09-07T21:02:28Z</updated>
	</entry>
</feed> ';



exit;

//********************************************************************//


/**
 *
 * @param String $url: valid website URL to create a snapshot.
 * @return mixed
 */
function requestURL($url = "") {
	$connection = curl_init();
	$headers = array(
// 			"GET /HTTP/1.1",
			"GET",
// 			"Content-type: text/xml;charset=\"utf-8\"",
// 			"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
// 			"Accept-Language: en-US,en;q=0.5",
			"Authorization: Bearer [eyJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIzMi4yZTQ0ZTVmNi1kYzA0LTQ0MjYtYWUzNS1lMzc3Nzk3MjkxYWMiLCJhdWQiOiJjb21tZXJjZSIsInBybiI6InZlcm5vbkBkYXRhY3VzdG9kaWFuLmNvbSIsInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJ1c2VyIl19fQ.iJgJTyZQv4CatSIhAx3ZzQjT3pyoEeUelGsEvM9vgu32hNAFtdRA2EEU3p7LEv7AlgEnemBPaF11UfTN1p5mV9wti8WGfbK7yYGrbsIfxbC_Qtlu22BoZlu3IPPK-Per_w0_wc9EiaEZ_C9V2xMY2NdSoknvlWb181NFneDtROg]"
	);
	curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($connection, CURLOPT_ENCODING, 'UTF-8');
	curl_setopt($connection, CURLOPT_URL, $url);
	curl_setopt($connection, CURLOPT_AUTOREFERER, true);
	curl_setopt($connection, CURLOPT_REFERER, SERVER);
	curl_setopt($connection, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($connection, CURLOPT_HEADER, false);
	curl_setopt($connection, CURLOPT_MAXREDIRS, 10);
	curl_setopt($connection, CURLOPT_CONNECTTIMEOUT, 180);//value: 10
	curl_setopt($connection, CURLOPT_TIMEOUT, 180);//value: 20
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// 	curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/BuiltinObjectToken-EquifaxSecureCA.crt");
	curl_setopt($ch, CURLOPT_CAINFO, "cacert.pem");
	curl_setopt($ch, CURLOPT_SSLCERT, "cert.crt");

	// User Agent: Chrome 20.0.1092.0
	curl_setopt($connection, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1092.0 Safari/536.6");
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	$finalURLContent	= curl_exec($connection);
	
	$header = curl_getinfo( $connection );
	$return = array (
			'httpCode' => curl_getinfo($handle, CURLINFO_HTTP_CODE),
			'error' => curl_errno( $connection ),
			'errmsg' => curl_error($connection),
			'header' => curl_getinfo( $connection ),
			'finalURLContent' => curl_exec($connection)
	);
	curl_close($connection);
	return $return;
}

?>