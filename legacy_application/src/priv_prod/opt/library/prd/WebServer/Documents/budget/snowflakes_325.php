<html>
	<head>
	<style type="text/css">
		svg { height: 100%; width: 100%; }
		.svg-snowglobe .snow { 
		  fill: #ffffff; 
		  fill-opacity: 0;
		}
		.svg-snowglobe .base { fill: hsl(145, 63%, 22%); }
		.svg-snowglobe .globe { fill: hsl(214, 57%, 85%); }
		.svg-snowglobe .water { fill: hsl(216, 45%, 51%); }
		.svg-snowglobe .snow { 
			-webkit-animation-name: snowfall;
			-webkit-animation-duration: 10s;
			-webkit-animation-iteration-count: infinite;
			-webkit-animation-timing-function: ease-in;
			animation-name: snowfall;
			animation-duration: 10s;
			animation-iteration-count: infinite;
			animation-timing-function: ease-in;
		}
		.svg-snowglobe .snow:nth-child(1) { 
			-webkit-animation-delay: 2s; 
			animation-delay: 2s; 
		}
		.svg-snowglobe .snow:nth-child(2) { 
			-webkit-animation-delay: 4s; 
			animation-delay: 4s; 
		}
		.svg-snowglobe .snow:nth-child(3) { 
			-webkit-animation-delay: 6s; 
			animation-delay: 6s; 
		}
		.svg-snowglobe .snow:nth-child(4) { 
			-webkit-animation-delay: 8s; 
			animation-delay: 8s; 
		}
		.svg-snowglobe .snow:nth-child(5) { 
			-webkit-animation-delay: 10s;
			animation-delay: 10s;
		}
		.svg-snowglobe .snow:nth-child(6) { 
			-webkit-animation-delay: 12s;
			animation-delay: 12s;
		}
		.svg-snowglobe .snow:nth-child(7) { 
			-webkit-animation-delay: 14s;
			animation-delay: 14s;
		}
		.svg-snowglobe .snow:nth-child(8) { 
			-webkit-animation-delay: 16s; 
			animation-delay: 16s; 
		}
		.svg-snowglobe .snow:nth-child(9) { 
			-webkit-animation-delay: 18s;
			animation-delay: 18s;
		}
		.svg-snowglobe .snow:nth-child(10) { 
			-webkit-animation-delay: 20s;
			animation-delay: 20s;
		}
		@-webkit-keyframes snowfall { 
			0% { fill-opacity: 0; }
			25% { fill-opacity: 1; }
			50% { -webkit-transform: translateY(25px); fill-opacity: 0; }
			100% { fill-opacity: 0 }
		}
		@keyframes snowfall { 
			0% { fill-opacity: 0; }
			25% { fill-opacity: 1; }
			50% { transform: translateY(25px); fill-opacity: 0; }
			100% { fill-opacity: 0 }
		}
	</style>
</head>
<body>
<?php
if(empty($_SESSION)){session_start();}
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempid1=substr($tempid,0,-2);
/*
if($tempid=='Biddix1484')
{
echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

}
*/
/*
if($beacnum=='60033242')
{echo "<table align='center'><tr><th>Hello Lisa and Welcome to NC State Parks</th></tr><tr><tr><th>ALL Features are now working.<br /> Tony P Bass (February 3, 2014)</th></tr></table>";
}
*/

extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include ("header_logo_apple2.php");
?>

	<svg class="svg-snowglobe" 
		viewBox="0 0 64 64" 
		xmlns="http://www.w3.org/2000/svg">

		<defs>
			<clipPath id="globeClipPath">
				<circle cx="32" cy="31" r="26.825"/>
			</clipPath>
		</defs>

			<path class="outline"
			    d="M0,63.349h64l-6.258-14.086h-1.016c3.805-5.207,5.891-11.449,5.891-17.997c0-16.881-13.742-30.614-30.627-30.614c-16.877,0-30.612,13.733-30.612,30.614c0,6.543,2.082,12.793,5.875,17.997h-1L0,63.349z"
			    />
			<polygon 
				class="base"
				points="57.967,59.431 6.028,59.431 8.804,53.181 55.195,53.181"
				/>
			<path 
			    class="globe"
			    d="M31.99,4.571c14.729,0,26.707,11.976,26.707,26.698c0,3.861-0.846,7.587-2.398,11.009c-1.053,0.086-1.842,0.215-2.58,0.352c-1.043,0.195-2.035,0.375-4.066,0.375c-2.027,0-3.02-0.18-4.062-0.375c-1.176-0.215-2.387-0.441-4.785-0.441c-0.191,0-0.332,0.012-0.512,0.016v-5.695h2.656l-3.887-2.73v-3.7h-2.441v1.979l-4.619-3.245l-10.956,7.696h2.66v5.695c-0.195-0.004-0.353-0.016-0.562-0.016c-2.388,0-3.601,0.227-4.773,0.441c-1.042,0.195-2.031,0.375-4.054,0.375c-2.024,0-3.011-0.18-4.053-0.375c-0.735-0.137-1.523-0.266-2.571-0.352c-1.548-3.422-2.395-7.156-2.395-11.009C5.298,16.547,17.271,4.571,31.99,4.571z"
			    />
			<path 
			    class="water"
			    fill="#4875BA" 
			    d="M10.162,46.591c1.012,0.18,2.174,0.332,4.156,0.332c2.384,0,3.596-0.223,4.768-0.438c1.043-0.195,2.031-0.375,4.061-0.375c2.025,0,3.012,0.18,4.053,0.375c1.175,0.215,2.386,0.438,4.779,0.438c2.381,0,3.596-0.223,4.768-0.438c1.043-0.195,2.031-0.375,4.059-0.375c2.035,0,3.027,0.18,4.07,0.375c1.176,0.215,2.387,0.438,4.777,0.438c1.992,0,3.16-0.156,4.18-0.332c-0.656,0.93-1.371,1.824-2.148,2.672h-39.39C11.52,48.415,10.816,47.521,10.162,46.591z"
			    />
			<g>

			<g class="group-snow" clip-path="url(#globeClipPath)">
				<circle class="snow" 
					cx="49.498" 
					cy="8.482" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="35.748" 
					y="2.783" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="21.001" 
					cy="4.728" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="28.25" 
					cy="2.783" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="42.997" 
					cy="4.728" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="14.502" 
					cy="8.482" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="9.194" 
					cy="13.793" 
					r="2.5"
					/>
				<circle class="snow" 
					cx="54.806" 
					cy="13.793" 
					r="2.5"
					/>
			</g>
	</svg>
</body>
</html>