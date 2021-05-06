<?php

	/**
	 * The plugin bootstrap file
	 *
	 * This file is read by WordPress to generate the plugin information in the plugin
	 * admin area. This file also includes all of the dependencies used by the plugin,
	 * registers the activation and deactivation functions, and defines a function
	 * that starts the plugin.
	 *
	 * @link              https://github.com/Merchans/chi-make-certificate
	 * @since             1.0.0
	 * @package           Chi_Make_Certificate
	 *
	 * @wordpress-plugin
	 * Plugin Name:       CHI Make Certificate
	 * Plugin URI:        chi-make-certificate
	 * Description:       Make PDF Certificate
	 * Version:           1.0.0
	 * Author:            Richard Markovič
	 * Author URI:        https://github.com/Merchans/chi-make-certificate
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       chi-make-certificate
	 * Domain Path:       /languages
	 */

// Add autoloader
	require __DIR__ . '/vendor/autoload.php';


	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	/**
	 * Currently plugin version.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'CHI_MAKE_CERTIFICATE_VERSION', '1.0.0' );

	function make_pdf_certificat( $name = null, $course_name = null, $credit = 3, $professional_guarantor = null, $CKL_id = null, $created_at = null, $CKL_register = null ) {

		$basic_path = dirname( __FILE__, "1" );
		$html       = '
	<style>

		body {
			font-family: "Source Sans Pro", sans-serif;
			margin: 0 auto;
			color: #1B1717;
			background: white;
		}

		.a4 {
			height: 842px;
			width: 595px;
			margin: 0 auto;
			background: white;
			position: relative;
		}

		.badge {
			width: 100px;
			position: absolute;
			top: -60px;
			left: 4px;
		}

		.stamp {
			width: 150px;
			align-self: flex-end;
			z-index: 10;
		}

		header img {
			width: 595px;
			padding: 0;
			display: block;
			margin: 0 auto;
		}
		header  {
			text-align: center;
		}

footer{
		margin: 4.7rem 0rem;
		}

		footer p {

    font-size: 1.5rem;
    line-height: 2rem;
}
		.pre-footer {
			position: absolute;
			width: 100%;
			bottom: 222px;
		}
		section.text {
			display: flex;
			flex-direction: column;
		}
		h1 {
			font-size: 2.5rem;
			text-align: center;
			font-weight: normal;
			line-height: 4rem;
			color:#CC3433;
		}
		h2 {
    font-size: 2rem;
    text-align: center;
}
small
{
			text-align: center;
    font-size: 1.2rem;
		}
		p {
			text-align: center;
    font-size: 1.5rem;
    margin-top: 1.4rem;
		}
		.uppercase{
			text-transform: uppercase;
			text-align: center;
		}
		h3 {
		font-size: 2rem;
		margin-bottom: 1rem;
}

		h4 {
		font-size: 1.7rem;
		margin-bottom: 0.5rem;
}
		h1.uppercase {
    line-height: 3rem;
    font-weight: bold;
    font-size: 3.3rem;
    margin-bottom: 0;
		}
	</style>
</head>
<body>
<section class="a4">
	<header>
		<img src="' . $basic_path . '/img/certificat-header.png" alt="CHI zahlavi">
		<small><em>Czech Health Interactive, Národní třída 58/32, 110 00 Praha 1</em></small>
	</header>
	<section class="text">
		<h1 class="uppercase">
			Potvrzení o účasti <br><br>na vzdělávací akci
		</h1>
		<p>
			<em>pořádané v rámci celoživotního vzdělávání lékařů <br> dle stavovského předpisu ČLK č.16</em>
		</p>
		<br>
		<h2><em>' . $name . '</em></h2>
		<br>
		<br>
		<h3 class="uppercase">' . $course_name . '</h3>
		<p>e-learningový kurz na portálu kongresonline.cz</p>
		<h4 class="uppercase">počet přidělených kreditů: ' . $credit . '</h4>
	</section>
	<br>
	<footer>
		<p>
			Datum absolvování testu: ' . $created_at . ' <br>
			V centrálním registru je akce vedena pod číslem: '. $CKL_register .'<br>
			Odborný garant: ' . $professional_guarantor . '
		</p>
	</footer>
</section>
</body>
</html>';

		$mpdf = new \Mpdf\Mpdf();


		$mpdf->SetTitle( "CERTIFIKÁT-" . $name . "" );
		$mpdf->SetAuthor( 'Autor' );
		$mpdf->SetCreator( 'Vytvořil' );
		$mpdf->SetSubject( 'Předmět' );
		$mpdf->SetKeywords( 'Klíčová slova' );
		$mpdf->WriteHTML( $html );
		$filename = $CKL_id . "-certifikat.pdf";
		$path     = wp_upload_dir()['basedir'];
		$mpdf->Output( $path . '/certifikaty/' . $filename, "F" );


	}

//	http://localhost:8888/Users/merchans/www/WordpPress/KongresOnline/wp-content/uploads/certifikaty/122222-certifikat.pdf
//	http://localhost:8888/WordpPress/KongresOnline/wp-content/uploads/2021/01/covid_vakcina.jpg

	if ( isset( $_GET["make_pdf"] ) ) {

		$path = wp_upload_dir()['baseurl'];

		$CKL_id = $_GET["ckl_id"];


		// The location of the PDF file
		// on the server
		$filename = $path . '/certifikaty/' . $CKL_id . '-certifikat.pdf';

		// Header content type
		header( "Content-type: application/pdf" );

		header( "Content-Length: " . filesize( $filename ) );

		// Send the file to the browser.
		readfile( $filename );
	}

	function make_pdf_certificate( $atts ) {


		$path = wp_upload_dir()['baseurl'];

//		http://localhost:8888/Users/merchans/www/WordpPress/KongresOnline/wp-content/uploads/certifikaty/122222-certifikat.pdf



		$filename = $path . '/certifikaty/' . $atts['ckl'] . '-certifikat.pdf';

		$ckl = $atts['ckl'];

		$date = new DateTime();
		$atts = shortcode_atts( array(
			'ckl'              => '',
			'ckl_registr'     => '',
			'jmeno_doktora'    => '',
			'jmeno_kurzu'      => '',
			'kredity'          => 3,
			'garant_kurzu'     => '',
			'datum_vystavenia' => $date->format("j. n. Y"),
			'nazev_tlacitka'   => 'Stáhnout certifikát',
			'class'            => 'btn btn-success',
		), $atts );


//		$name = null, $course_name = null, $credit = 3, $professional_guarantor = null, $CKL_id = null, $created_at = null


		make_pdf_certificat( $atts['jmeno_doktora'], $atts['jmeno_kurzu'], $atts['kredity'], $atts['garant_kurzu'], $atts['ckl'], $atts['datum_vystavenia'], $atts['ckl_registr'] );

		return '<a target="_blank" class="' . esc_attr( $atts['class'] ) . '" href="' . $path . '/certifikaty/' . $atts['ckl'] . '-certifikat.pdf' . '">' . $atts['nazev_tlacitka'] . '</a>';

	}

	add_shortcode( 'certifikat', 'make_pdf_certificate' );

