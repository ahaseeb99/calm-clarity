<?php
/*include ROOTPATH . '/includes/lib/StableDiffusion.php';

$stableDiffusion = new StableDiffusion(get_image_api_key('stable-diffusion'));

$data = curl_file_create('storage/ai_images/642bef3d2b4d7.png');

$response = $stableDiffusion->imageVariation([
    "text_prompts[0][text]" => 'Enhance this image',
    "samples" => 1,
    "steps" => 50,
    "image_strength" => 0.35,
    "init_image_mode" => "IMAGE_STRENGTH",
    "init_image" => $data
]);

$response = json_decode($response, true);
if (isset($response['artifacts'])) {
    foreach ($response['artifacts'] as $image) {

        $name = uniqid() . '.png';
        $target_dir = ROOTPATH . '/storage/ai_images/';
        file_put_contents($target_dir . $name, base64_decode($image['base64']));
        echo SITEURL . '/storage/ai_images/'.$name;
        echo '<img src="'.SITEURL . '/storage/ai_images/'.$name.'">';
    }
}else {
    echo $response['message'];
}*/