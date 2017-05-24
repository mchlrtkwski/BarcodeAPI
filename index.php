<!--<table>-->
<!--<tr>-->

<?php
if (isset($_GET['type'])) {
	if ($_GET['type'] == "128") {
		if (isset($_GET['code'])) {
			$upc128_values = array("SP"=>0,"!"=>1,'"'=>2,"pound"=>3,"$"=>4,"%"=>5,"&"=>6,"'"=>7,"("=>8,")"=>9,"*"=>10,"+"=>11,","=>12,"-"=>13,"."=>14,"/"=>15,"0"=>16,"1"=>17,"2"=>18,"3"=>19,"4"=>20,"5"=>21,"6"=>22,"7"=>23,"8"=>24,"9"=>25,":"=>26,";"=>27,"<"=>28,"="=>29,">"=>30,"?"=>31,"@"=>32,"A"=>33,"B"=>34,"C"=>35,"D"=>36,"E"=>37,"F"=>38,"G"=>39,"H"=>40,"I"=>41,"J"=>42,"K"=>43,"L"=>44,"M"=>45,"N"=>46,"O"=>47,"P"=>48,"Q"=>49,"R"=>50,"S"=>51,"T"=>52,"U"=>53,"V"=>54,"W"=>55,"X"=>56,"Y"=>57,"Z"=>58,"["=>59,"\\"=>60,"]"=>61," "=>62,"_"=>63,"`"=>64,"a"=>65,"b"=>66,"c"=>67,"d"=>68,"e"=>69,"f"=>70,"g"=>71,"h"=>72,"i"=>73,"j"=>74,"k"=>75,"l"=>76,"m"=>77,"n"=>78,"o"=>79,"p"=>80,"q"=>81,"r"=>82,"s"=>83,"t"=>84,"u"=>85,"v"=>86,"w"=>87,"x"=>88,"y"=>89,"z"=>90,"{"=>91,"|"=>92,"}"=>93,"~"=>94,"DEL"=>95,"FNC3"=>96,"FNC2"=>97,"SHIFT"=>98,"CODE_C"=>99,"FNC4"=>100,"CODE_A"=>101,"FNC1"=>102,"START_A"=>103,"START_B"=>104,"START"=>105, "STOP"=>106);
			$upc128_lines = array("11011001100","11001101100","11001100110","10010011000","10010001100","10001001100","10011001000","10011000100","10001100100","11001001000","11001000100","11000100100","10110011100","10011011100","10011001110","10111001100","10011101100","10011100110","11001110010","11001011100","11001001110","11011100100","11001110100","11101101110","11101001100","11100101100","11100100110","11101100100","11100110100","11100110010","11011011000","11011000110","11000110110","10100011000","10001011000","10001000110","10110001000","10001101000","10001100010","11010001000","11000101000","11000100010","10110111000","10110001110","10001101110","10111011000","10111000110","10001110110","11101110110","11010001110","11000101110","11011101000","11011100010","11011101110","11101011000","11101000110","11100010110","11101101000","11101100010","11100011010","11101111010","11001000010","11110001010","10100110000","10100001100","10010110000","10010000110","10000101100","10000100110","10110010000","10110000100","10011010000","10011000010","10000110100","10000110010","11000010010","11001010000","11110111010","11000010100","10001111010","10100111100","10010111100","10010011110","10111100100","10011110100","10011110010","11110100100","11110010100","11110010010","11011011110","11011110110","11110110110","10101111000","10100011110","10001011110","10111101000","10111100010","11110101000","11110100010","10111011110","10111101110","11101011110","11110101110","11010000100","11010010000","11010011100","1100011101011");
			$code = $_GET['code'];
			$codelength = strlen($code);
			$checksum = 0;
			$codeString = $upc128_lines[$upc128_values['START_A']];
			for ($i=0; $i < $codelength; $i++) {
				$codeString = $codeString . $upc128_lines[$upc128_values[$code[$i]]];
				$checksum = $checksum + ($upc128_values[$code[$i]] * ($i + 1));
			}
			$checksum = $checksum % 103;
			$codeString = $codeString . $upc128_lines[$checksum] . $upc128_lines[$upc128_values['STOP']];
			$width = (strlen($codeString)) + 22;
			$height = 75;
			$image = imagecreate($width, $height);
			imageAlphaBlending($image, true);
			imageSaveAlpha($image, true);
			$location = 12;
			$color_white = imagecolorallocate ( $image ,255,255,255);
			$color_black = imagecolorallocate ( $image ,0,0,0);
			for ($i=0; $i < strlen($codeString); $i++) {
				if ($codeString[$i] == "1") {
					for ($y=0; $y < $height; $y++) {
						imagesetpixel ($image, $location , $y , $color_black);
					}
					$location = $location + 1;
				}else {
					$location = $location + 1;
				}

			}
			ob_start();
			imagepng($image);
			$contents =  ob_get_contents();
			ob_end_clean();
			echo "<img id = '$code' style='width:100%;margin-left:auto; margin-right:auto;' src='data:image/png;base64," . base64_encode($contents) . "'>";
		}
	}

	if ($_GET['type'] == "upc_a") {
		if (isset($_GET['code'])) {
			if (strlen($_GET['code']) <= 12) {
				$upcA_values = array("START"=>0,"L_0"=>1,"L_1"=>2,"L_2"=>3,"L_3"=>4,"L_4"=>5,"L_5"=>6,"L_6"=>7,"L_7"=>8,"L_8"=>9,"L_9"=>10,"MID"=>11,"R_0"=>12,"R_1"=>13,"R_2"=>14,"R_3"=>15,"R_4"=>16,"R_5"=>17,"R_6"=>18,"R_7"=>19,"R_8"=>20,"R_9"=>21,"END"=>22);
				$upcA_lines = array("101","0001101","0011001","0010011","0111101","0100011","0110001","0101111","0111011","0110111","0001011","01010","1110010","1100110","1101100","1000010","1011100","1001110","1010000","1000100","1001000","1110100","101");
				$code = $_GET['code'];
				$codelength = strlen($code);
				$checksum = 0;
				$codeString = $upcA_lines[$upcA_values['START']];
				for ($i=0; $i < $codelength; $i++) {
					if ($i < 6) {
						$codeString = $codeString . $upcA_lines[$upcA_values["L_" . $code[$i]]];
					}
					if ($i == 6){
						$codeString = $codeString . $upcA_lines[$upcA_values['MID']];
						$codeString = $codeString . $upcA_lines[$upcA_values["R_" . $code[$i]]];
					}
					if ($i >6) {
						$codeString = $codeString . $upcA_lines[$upcA_values["R_" . $code[$i]]];
					}
				}

				$codeString = $codeString . $upcA_lines[$upcA_values['END']];
				$width = (strlen($codeString)) + 22;
				$height = 75;
				$image = imagecreate($width, $height);
				imageAlphaBlending($image, true);
				imageSaveAlpha($image, true);
				$location = 12;
				$color_white = imagecolorallocate ( $image ,255,255,255);
				$color_black = imagecolorallocate ( $image ,0,0,0);
				for ($i=0; $i < strlen($codeString); $i++) {
					if ($codeString[$i] == "1") {
						for ($y=0; $y < $height; $y++) {
							imagesetpixel ($image, $location , $y , $color_black);
						}
						$location = $location + 1;
					}else {
						$location = $location + 1;
					}

				}
				ob_start();
				imagepng($image);
				$contents =  ob_get_contents();
				ob_end_clean();
				echo "<img id = '$code' style='width:100%;margin-left:auto; margin-right:auto;' src='data:image/png;base64," . base64_encode($contents) . "'>";

			}
		}
	}
}

?>
