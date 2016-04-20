<?php
	include "url.php";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<link rel="stylesheet" type="text/css" href="../c.min.css" />
<script src="../c.min.js"></script>
<title>Лабораторная</title>
</head>

<body>
<div id="container">
    <div id="header">
        <a href="../index.html"><h1>Random</h1></a>
    </div>
    <!-- Верхнее меню -->
    <div id="menu">
        <ul>
            <li class="menuitem"><a href="lab1.php">Равномерное распределение</a></li>
            <li class="menuitem"><a href="lab2.php">Распределение Симпсона</a></li>
            <li class="menuitem"><a href="lab3.php">Нормальное распределение</a></li>
            <li class="menuitem"><a href="lab4.php">Экспоненциальное распределение</a></li>
            <li class="menuitem"><a href="lab5.php" class="active">Распределение Эрланга</a></li>
        </ul>
    </div>
        <!-- Содержимое страницы -->
    <div class="content">
    <h2>Лабораторная работа</h2>
        <div class="gg">
	<input id="but" type="button" value="Смоделировать систему">
	<div class="rig">
		Кол-во потребителей <input type="text" id="r" value="">
		Кол-во товаров <input type="text" id="m" value="">
		Кол-во дней <input type="text" id="G" value="">
	</div>
</div>


<div class="graph">
	<span class='h' id='h'>Процент удовлетворенности потребителей по каждому товару</span>
	<div class="ct-chart ct-perfect-fourth" id="chart1"></div>
</div>

<div class="info">
	<span id='H'></span><br><br>
	<span id='L'></span><br><br>

</div> 

<div class="graph">
	<span class='h' id='hh'>Количество товара на начало и конец дня</span>
	<div class="ct-chart ct-perfect-fourth" id="chart2"></div>
</div>
<script>

function getMasRand(min, max){
	return Math.round(Math.random() * (max - min) + min);
}
function arrayPad(ar, size, value) {
	var len = Math.abs(size) - ar.length;
	var a = [].concat(ar);
	if (len <= 0)
		return a;
	for(var i = 0; i < len; i++)
		size < 0 ? a.unshift(value) : a.push(value);
	return a;
}
document.getElementById('but').onclick = function() {
	document.getElementById('h').style.display = 'inline-block';
	document.getElementById('hh').style.display = 'inline-block';
	var m = 10, r = 2, G = 30;
	var b = arrayPad([], r, 10000), //15000
	l = arrayPad([], r, 8500), //8000
	C = [], a = [], R = arrayPad([], r, 6350), //6200
	A = 0, A1 = 0, S = 0, D = arrayPad([], r, 0), F = arrayPad([], r, 0),
	K = arrayPad([], r, 0), day = [], GlobC = [], GlobB = [], H = 0, L = 0
	proc = [], glob = [];

	while(S <= G){

		for (var i = 0; i < r; i++){
			a[i] = [];
			a[i][m] = 0;
			for (var j = 0; j < m; j++) {
				a[i][j] = getMasRand(500, 800);
				a[i][m] += a[i][j];
			};
		};

		for (var i = 0; i < r; i++) {
		};
		
		for (var i = 0; i < r; i++) {
			A += a[i][m];
		};

		for (var i = 0; i < r; i++) {
			F[i] += F[i] + a[i][m];
		};
		glob[S] = [];
		var countC = 0;
		for (var i = 0; i < r; i++) {
			C[i] = b[i] - a[i][m];
			countC += C[i];
		};
		GlobC.push(Math.round(countC/r));
		var countB = 0;
		for (var i = 0; i < r; i++) {
			if(C[i]<0){
				glob[S][i] = (100 - ((C[i]/b[i])*100));
				proc.push(100 - ((C[i]/a[i][m])*100));
				b[i] = R[i];
				D[i] = D[i] + C[i];
			}else if(C[i]<l[i]){
				glob[S][i] = (100 - ((C[i]/b[i])*100));
				proc.push(100 - ((C[i]/b[i])*100)); 
				b[i] = C[i] + R[i];
			}else{
				glob[S][i] = (100 - ((C[i]/b[i])*100));
				proc.push(100 - ((C[i]/b[i])*100));
				b[i] = C[i];
			}
			countB += b[i];

		};

		GlobB.push(Math.round(countB/r));

		day.push(S);
		A1 = A1 + A;
		S++;

	}
	//console.log('A1 => ' + A1);
	//console.log('S => ' + S);

	for (var i = 0; i < r; i++) {
		K[i] = D[i]/F[i];
	};
	//console.log('K => ' + K);

	for (var i = 0; i < r; i++) {
		H += D[i];
	};

	L = H/A1;

	document.getElementById('H').innerHTML = 'Общее количество неудовлетворенных заявок: ' + H;
	document.getElementById('L').innerHTML = 'Доля невыполненных заявок к общему числу заявок: ' + L.toFixed(4);
	
	var kkk = [], maxDay = [], maxR = [], l = 0;
	for (var i = 0; i < r; i++) {
	var lll = [];
		for (var S = 0; S < G; S++) {
			lll.push(glob[S][i]);
			if(glob[S][i] >= 95){
				maxR[l] = glob[S][i];
				maxDay[l] = S;
				l++;
			}
		};
		kkk.push(lll);
	};

console.log(maxDay);
console.log(maxR);

	var chart = new Chartist.Line('#chart1', {
  labels: day,
  series: kkk
}, {
  fullWidth: true,
  chartPadding: {
    right: 10
  },
  lineSmooth: Chartist.Interpolation.cardinal({
    fillHoles: true,
  }),
  low: 0
},{
  seriesBarDistance: 10,
  axisX: {
    offset: 60
  },
  axisY: {
    offset: 80,
    labelInterpolationFnc: function(value) {
      return value + ' %'
    },
    scaleMinSpace: 15
  }
});

	var data = {
	  labels: day,
	  series: [
	  		GlobB,
	  		GlobC
	  		]	  
	};

	var options = {
	  showPoint: true,
	  lineSmooth: false,
	  axisX: {
	    showGrid: false,
	    showLabel: true
	  },
	  axisY: {
	    offset: 60,
	    labelInterpolationFnc: function(value) {
	      return value;
	    }
	  }
	};

	new Chartist.Line('#chart2', data, options);

}
		
</script>
   <div class="gg">
	<input id="but" type="button" value="Смоделировать систему">
</div>


<div class="block">
	<div class="x" id='x'></div>
	<div class="x" id='x1'></div>
	<div class="x" id='x2'></div>
</div>

<div class="graph">
	<span class='h' id='h'>Коэффициенты загрузки устройств</span>
	<div class="ct-chart ct-perfect-fourth" id='chart1'></div>
</div>

<div class="bblock">
	<div class="graph2">
		<span class='h' id='hh'>Гистограмма частот X1</span>
		<div class="ct-chart ct-perfect-fourth" id='chart2'></div>
	</div>
	<div class="graph3">
		<span class='h' id='hhh'>Гистограмма частот X2</span>
		<div class="ct-chart ct-perfect-fourth" id='chart3'></div>
	</div>
</div>

<script>
function sortNumber(a, b){
	return a - b;
}
function getMasRand(min, max){
	return Math.round(Math.random() * (max - min) + min);
}
function arrayPad(ar, size, value) {
	var len = Math.abs(size) - ar.length;
	var a = [].concat(ar);
	if (len <= 0)
		return a;
	for(var i = 0; i < len; i++)
		size < 0 ? a.unshift(value) : a.push(value);
	return a;
}
function unique(arr) {
  var result = [];

  nextInput:
    for (var i = 0; i < arr.length; i++) {
      var str = arr[i]; 
      for (var j = 0; j < result.length; j++) { 
        if (result[j] == str) continue nextInput; 
      }
      result.push(str);
    }
  return result;
}
document.getElementById('but').onclick = function() {
	document.getElementById('x').innerHTML = '';
	document.getElementById('x1').innerHTML = '';
	document.getElementById('x2').innerHTML = '';
	document.getElementById('h').style.display = 'inline-block';
	document.getElementById('hh').style.display = 'inline-block';
	document.getElementById('hhh').style.display = 'inline-block';
	var l = 0, r = 200, up = 0, upp = 0, t1f = 0, t2f = 0,
	f1 = 0, f2 = 0, i1 = 0, i2 = 0,
	T1flow = 0, T2flow = 0,	flowSelect = true,
	ft1 = true, ft2 = true, T1 = 0, T2 = 0;
	var X1 = [], X2 = [], t1 = [], t2 = [], u1 = [], u2 = [],
	m1 = 0, m2 = 0, m3 = 0, m4 = 0;

	while(l<r){

		if(ft1 && ft2){
			if(up == 0)	T1flow = getMasRand(0, 1); else T1flow = 1;
			if(upp == 0) T2flow = getMasRand(0, 1);	else {T2flow = 1; upp = 0;}

			switch(T1flow + ' ' + T2flow){
				case '1 0':
					T1 = getMasRand(2, 4);
					if(f1 == 0){t1[i1] = l; i1++; t1f = 1;}
					ft1 = false;
					break;
				case '0 1':
					if(f2 == 1){T2 = 2;}else{T2 = 1;}
					if(f2 == 0){t2[i2] = l; i2++; t2f = 1;}
					ft2 = false;
					break;
				case '1 1':
					T1 = getMasRand(2, 4);
					ft1 = false;
					if(f2 == 1){T2 = 2;}else{T2 = 1;}
					ft2 = false;
					if(f1 == 0){t1[i1] = l; i1++; t1f = 1;}
					if(f2 == 0){t2[i2] = l; i2++; t2f = 1;}
					break;
				default:
					T1 = 0;
					T2 = 0;
					ft1 = true;
					ft2 = true;
					break;
			}
		}else if(ft1 == true && ft2 == false){
			if(up == 0)	T1flow = getMasRand(0, 1); else T1flow = 1;
			if(T1flow) {
				T1 = getMasRand(2, 4);
				if(f1 == 0){t1[i1] = l; i1++; t1f = 1;}
				ft1 = false;
			}
		}else if(ft1 == false && ft2 == true){
			if(upp == 0) T2flow = getMasRand(0, 1);	else {T2flow = 1; upp = 0;}
			if(T2flow) {
				if(f2 == 1){T2 = 2;}else{T2 = 1;}
				if(f2 == 0){t2[i2] = l; i2++; t2f = 1;}
				ft2 = false;
			}
		}

		if(T1 > 0){
			if(f1 == 2){
				X1[l] =	2;
				m2++;
				T1--;
				if(T1 == 0) {f1 = 0; ft1 = true; up = 0; t1[i1] = l-1;i1++;}
			}
			if(f1 == 1){
				X1[l] = 1;
				m1++;
				T1--;
				if(T1 == 0) {f1 = 2; ft1 = true; up = 1;}
			}
			if(f1 == 0){
				if(X1[l - 1] == 2){
					X1[l] = 0;
				}else{
					X1[l] = 4;
					m4++;
					T1--;
					if(T1 == 0) {f1 = 1; ft1 = true; up = 1;}
				}
			}

		}

		if(T2 > 0){
			if(f2 == 2){
				X2[l] = 3;
				m3++;
				T2--;
				if(T2 == 0) {f2 = 0; ft2 = true; upp = 0; t2[i2] = l; i2++;}
			}
			if(f2 == 1){
				if(X1[l] != 1){
					X2[l] = 1;
					m1++;
					T2--;
					if(T2 == 0) {f2 = 2; ft2 = true;upp = 0;}
				}else{
					X2[l] = 0;
					upp = 1;
				}
			}
			if(f2 == 0){
				X2[l] = 3;
				m3++;
				T2--;
				if(T2 == 0) {f2 = 1; ft2 = true; upp = 0;}
			}

		}

		l++;
	}

	for (var i = 0; i < r; i++) {
		document.getElementById('x').innerHTML += '<div class="f">'+i+'</div>';
	}

	for (var i = 0; i < r; i++) {
		switch(X1[i]){
			case 4:
				document.getElementById('x1').innerHTML += '<div class="f" style="background: #ca0b03"></div>';
				break;
			case 1:
				document.getElementById('x1').innerHTML += '<div class="f" style="background: #0272a2"></div>';
				break;
			case 2:
				document.getElementById('x1').innerHTML += '<div class="f" style="background: #d7c703"></div>';
				break;
			default:
				document.getElementById('x1').innerHTML += '<div class="f"></div>';
				break;
		}
	};

	for (var i = 0; i < r; i++) {
		switch(X2[i]){
			case 3:
				document.getElementById('x2').innerHTML += '<div class="f" style="background: #83bd1a"></div>';
				break;
			case 1:
				document.getElementById('x2').innerHTML += '<div class="f" style="background: #0272a2"></div>';
				break;
			default:
				document.getElementById('x2').innerHTML += '<div class="f"></div>';
				break;
		}
	};

	
	if(t1.length%2)	var v = t1.length-1; else var v = t1.length;
	for (var i = 0, n = 0; i < v; i = i + 2, n++) {
		 u1[n] = t1[i+1] - t1[i];
	};
	if(t2.length%2)	var v = t2.length-1; else var v = t2.length;
	for (var i = 0, n = 0; i < v; i = i + 2, n++) {
		 u2[n] = t2[i+1] - t2[i];
	};
	m1 = m1/r;
	m2 = m2/r;
	m3 = m3/r;
	m4 = m4/r;

new Chartist.Bar('#chart1', {
	  labels: ['У-1', 'У-2', 'У-3', 'У-4'],
	  series: [m1, m2, m3, m4]
	}, {
	  distributeSeries: true,
	  reverseData: true,
	  horizontalBars: true,
	});

	var mas = [], vhod = [], ver = [];
	var count = 0, box = 0, series = [], ticks = [];

	u1.sort();
	box = 0;
	var m = 0;
	for (var i=0; i<u1.length; i++){
		count = 0;
	    for (var j=0; j<u1.length; j++){
	        if(u1[i]==u1[j] && j!=i) {
	                count++;
	        }   
	    }
	    ver[i] = +(count/u1.length).toFixed(3);
	}
	ver = unique(ver);
   	u1 = unique(u1);

	for (var i = 0; i < ver.length; i++) {
		series.push(ver[i]);
		ticks.push(u1[i]);
	};

	var data = {
	  labels: ticks,
	  series: [
	    series
	  ]
	};

	var options = {
	  seriesBarDistance: 10
	};

	var responsiveOptions = [
	  ['screen and (max-width: 640px)', {
	    seriesBarDistance: 5,
	    axisX: {
	      labelInterpolationFnc: function (value) {
	        return value[0];
	      }
	    }
	  }]
	];

	new Chartist.Bar('#chart2', data, options, responsiveOptions);

	var vhod = [], verr = [];
	var count = 0, box = 0, seriess = [], tickss = [];

	u2.sort();
	box = 0;
	var m = 0;
	for (var i=0; i<u2.length; i++){
		count = 0;
	    for (var j=0; j<u2.length; j++){
	        if(u2[i]==u2[j] && j!=i) {
	                count++;
	        }   
	    }
	    verr[i] = +(count/u2.length).toFixed(3);
	}
	verr = unique(verr);
   	u2 = unique(u2);

	for (var i = 0; i < verr.length; i++) {
		seriess.push(verr[i]);
		tickss.push(u2[i]);
	};

	var data = {
	  labels: tickss,
	  series: [
	    seriess
	  ]
	};

	var options = {
	  seriesBarDistance: 10
	};

	var responsiveOptions = [
	  ['screen and (max-width: 640px)', {
	    seriesBarDistance: 5,
	    axisX: {
	      labelInterpolationFnc: function (value) {
	        return value[0];
	      }
	    }
	  }]
	];

	new Chartist.Bar('#chart3', data, options, responsiveOptions);

}
</script>

    </div>
</body>
</html>