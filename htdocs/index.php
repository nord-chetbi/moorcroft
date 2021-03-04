<?  
    $size = array();
    $len  = array();
    $vol  = array();

    $products = json_decode(file_get_contents('products.json'), true );
    foreach($products as $product){
        if(!in_array($product['SIZE'], $size)){
            $size[]=$product['SIZE'];
        }
        if(!in_array($product['VOLTAGE'], $vol)){
            $vol[]=$product['VOLTAGE'];
        }
        if(!in_array($product['CABLE_LENGTH'], $len)){
            $len[]=$product['CABLE_LENGTH'];
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Product Upsell</title>
</head>
<body>

    <div class="header">
        <img src="http://www.atam.it/img_s/logo.png" alt="" class="logo">
        <div class="questions">

            <fieldset class="product_size">
                <label for="product_size">WHAT SIZE CONNECTOR DO YOU NEED?</label>
                <select name="product_size" id="product_size">
                    <option value="null">Please select...</option>
                    <? foreach ($size as $v) {
                        echo '<option value="'.$v.'">'.$v.'</option>';
                    } ?>
                </select>
            </fieldset>

            <fieldset class="disabled product_length">
                <label for="product_length">WHAT IS YOUR REQUIRED CABLE LENGTH?</label>
                <select name="product_length" id="product_length">
                    <option value="null">Please select...</option>
                    <? foreach ($len as $v) {
                        echo '<option value="'.$v.'">'.$v.'</option>';
                    } ?>
                </select>
            </fieldset>

            <fieldset class="disabled product_voltage">
                <label for="product_voltage">WHAT IS YOUR REQUIRED LED VOLTAGE?</label>
                <select name="product_voltage" id="product_voltage">
                    <option value="null">Please select...</option>
                    <? foreach ($vol as $v) {
                        echo '<option value="'.$v.'">'.$v.'</option>';
                    } ?>
                </select>
            </fieldset>

        </div>
    </div>

    <div class="products">
        
        <? foreach($products as $product) { ?>
            <a href="<?= $product['URL']; ?>" class="item hidden"
                data-vol="<?= $product['VOLTAGE']; ?>"
                data-len="<?= $product['CABLE_LENGTH']; ?>"
                data-size="<?= $product['SIZE']; ?>"
            >
                <img class="product_image" src="img/KC1362.png" alt="">
                <div class="content">
                    <div class="part_number"><?= $product['PART_NUMBER']; ?></div>
                    <div class="price">£<?= number_format((float)$product['PRICE'], 2, '.', ''); ?></div>
                    <div class="size small">SIZE: <?= $product['SIZE']; ?></div>
                    <div class="volt small">VOLTAGE: <?= $product['VOLTAGE']; ?></div>
                    <div class="len small">CABLE_LENGTH: <?= $product['CABLE_LENGTH']; ?></div>
                </div>
            </a>
        <? } ?>

    </div>

    <script>
        const vol  = document.getElementById('product_voltage');
        const len  = document.getElementById('product_length');
        const size = document.getElementById('product_size');

        const volEl  = document.querySelector('.product_voltage');
        const lenEl  = document.querySelector('.product_length');
        const sizeEl = document.querySelector('.product_size');
        const items  = Array.from(document.querySelectorAll('.item'));

        let selectedvol, selectedlen, selectedsize;

        function filterProducts() {
            items.forEach((item) => {
                item.classList.add('hidden');
                if (
                    item.dataset.vol === selectedvol &&
                    item.dataset.size === selectedsize &&
                    item.dataset.len === selectedlen
                ) {
                    item.classList.remove('hidden');
                }
            });
        }

        size.addEventListener('change', (event) => {
            if( size.value !== 'null' ) {
                selectedsize = size.value;
                lenEl.classList.remove('hidden');
                filterProducts();
            }
        });

        len.addEventListener('change', (event) => {
            if( len.value !== 'null' ) {
                selectedlen = len.value;
                volEl.classList.remove('hidden');
                filterProducts();
            }
        });

        vol.addEventListener('change', (event) => {
            if( vol.value !== 'null' ) {
                selectedvol = vol.value;
                filterProducts();
            }
        });


    </script>
</body>
</html>