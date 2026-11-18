<?php
/**
 * Every page of the static export: path => content key, language, the page it
 * translates, and the template. Parents follow the path; keys match the ones
 * tools/content/ already used so existing `{page: key}` links keep resolving.
 *
 * @package Starter_Flexible
 */

$app = 'page-app.php';

return array(
	// path, key, lang, translation_of, template, front_page.
	array( 'path' => '/', 'key' => 'home', 'lang' => 'vi', 'slug' => 'trang-chu', 'front_page' => true ),
	array( 'path' => '/gioi-thieu/', 'key' => 'about', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/', 'key' => 'capabilities', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/thiet-ke-tau/', 'key' => 'service_01', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/thiet-ke-tau/tau-ca-vo-thep/', 'key' => 'design_steel', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/thiet-ke-tau/tau-composite/', 'key' => 'design_composite', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/thiet-ke-tau/hoan-cai-chuyen-nghe/', 'key' => 'design_conversion', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/thiet-ke-tau/tau-khach-cano/', 'key' => 'design_passenger', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/ho-so-dang-kiem/', 'key' => 'approval_docs', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/dich-vu-cntt/', 'key' => 'service_03', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/marine-rd/', 'key' => 'service_rnd', 'lang' => 'vi' ),
	array( 'path' => '/nang-luc/marine-rd/cong-trinh/', 'key' => 'publications', 'lang' => 'vi' ),
	array( 'path' => '/du-an/', 'key' => 'projects', 'lang' => 'vi' ),
	array( 'path' => '/tin-tuc/', 'key' => 'insights', 'lang' => 'vi' ),
	array( 'path' => '/lien-he/', 'key' => 'contact', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/', 'key' => 'tools', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/nhiem-vu-thu/', 'key' => 'design_brief', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/chuyen-doi-cong-suat/', 'key' => 'tool_power', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/kiem-tra-duong-kinh-truc-chan-vit/', 'key' => 'tool_shaft', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/tra-cuu-dong-co/', 'key' => 'tool_engine', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/mo-phong-on-dinh-tau/', 'key' => 'app_stability', 'lang' => 'vi', 'template' => $app ),
	array( 'path' => '/cong-cu/mo-phong-on-dinh-tau/gioi-thieu/', 'key' => 'app_stability_about', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/suc-can-cong-suat/', 'key' => 'app_resistance', 'lang' => 'vi', 'template' => $app ),
	array( 'path' => '/cong-cu/suc-can-cong-suat/gioi-thieu/', 'key' => 'app_resistance_about', 'lang' => 'vi' ),
	array( 'path' => '/cong-cu/mo-phong-ket-cau-tau/', 'key' => 'app_structure', 'lang' => 'vi', 'template' => $app ),

	array( 'path' => '/en/home/', 'key' => 'home_en', 'lang' => 'en', 'translation_of' => 'home' ),
	array( 'path' => '/en/about/', 'key' => 'about_en', 'lang' => 'en', 'translation_of' => 'about' ),
	array( 'path' => '/en/capabilities/', 'key' => 'capabilities_en', 'lang' => 'en', 'translation_of' => 'capabilities' ),
	array( 'path' => '/en/capabilities/ship-design/', 'key' => 'service_01_en', 'lang' => 'en', 'translation_of' => 'service_01' ),
	array( 'path' => '/en/capabilities/ship-design/steel-fishing-vessel-design/', 'key' => 'design_steel_en', 'lang' => 'en', 'translation_of' => 'design_steel' ),
	array( 'path' => '/en/capabilities/ship-design/frp-composite-boat-design/', 'key' => 'design_composite_en', 'lang' => 'en', 'translation_of' => 'design_composite' ),
	array( 'path' => '/en/capabilities/ship-design/fishing-vessel-conversion/', 'key' => 'design_conversion_en', 'lang' => 'en', 'translation_of' => 'design_conversion' ),
	array( 'path' => '/en/capabilities/ship-design/passenger-boat-design/', 'key' => 'design_passenger_en', 'lang' => 'en', 'translation_of' => 'design_passenger' ),
	array( 'path' => '/en/capabilities/approval-documents/', 'key' => 'approval_docs_en', 'lang' => 'en', 'translation_of' => 'approval_docs' ),
	array( 'path' => '/en/capabilities/software/', 'key' => 'service_03_en', 'lang' => 'en', 'translation_of' => 'service_03' ),
	array( 'path' => '/en/capabilities/research-development/', 'key' => 'service_rnd_en', 'lang' => 'en', 'translation_of' => 'service_rnd' ),
	array( 'path' => '/en/capabilities/research-development/publications/', 'key' => 'publications_en', 'lang' => 'en', 'translation_of' => 'publications' ),
	array( 'path' => '/en/projects/', 'key' => 'projects_en', 'lang' => 'en', 'translation_of' => 'projects' ),
	array( 'path' => '/en/insights/', 'key' => 'insights_en', 'lang' => 'en', 'translation_of' => 'insights' ),
	array( 'path' => '/en/contact/', 'key' => 'contact_en', 'lang' => 'en', 'translation_of' => 'contact' ),
	array( 'path' => '/en/tools/', 'key' => 'tools_en', 'lang' => 'en', 'translation_of' => 'tools' ),
	array( 'path' => '/en/design-brief/', 'key' => 'design_brief_en', 'lang' => 'en', 'translation_of' => 'design_brief' ),
	array( 'path' => '/en/tools/power-converter/', 'key' => 'tool_power_en', 'lang' => 'en', 'translation_of' => 'tool_power' ),
	array( 'path' => '/en/tools/propeller-shaft-diameter/', 'key' => 'tool_shaft_en', 'lang' => 'en', 'translation_of' => 'tool_shaft' ),
	array( 'path' => '/en/tools/engine-lookup/', 'key' => 'tool_engine_en', 'lang' => 'en', 'translation_of' => 'tool_engine' ),
	array( 'path' => '/en/tools/ship-stability-simulator/', 'key' => 'app_stability_en', 'lang' => 'en', 'translation_of' => 'app_stability', 'template' => $app ),
	array( 'path' => '/en/tools/ship-stability-simulator/about/', 'key' => 'app_stability_about_en', 'lang' => 'en', 'translation_of' => 'app_stability_about' ),
	array( 'path' => '/en/tools/resistance-power-simulator/', 'key' => 'app_resistance_en', 'lang' => 'en', 'translation_of' => 'app_resistance', 'template' => $app ),
	array( 'path' => '/en/tools/resistance-power-simulator/about/', 'key' => 'app_resistance_about_en', 'lang' => 'en', 'translation_of' => 'app_resistance_about' ),
);
