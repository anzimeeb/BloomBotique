<?php
require_once 'header.php';
require_once '../connection.php';

// Initialize variables to store selections
$selectedSize = isset($_POST['size']) ? $_POST['size'] : '';
$selectedMainFlower = isset($_POST['main_flower']) ? $_POST['main_flower'] : '';
$selectedFiller = isset($_POST['filler']) ? $_POST['filler'] : '';
$selectedWrapper = isset($_POST['wrapper']) ? $_POST['wrapper'] : '';
$selectedRibbon = isset($_POST['ribbon']) ? $_POST['ribbon'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Process form submission
if (isset($_POST['add_to_cart'])) {
    $cartSuccess = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom - Create Your Own Bouquet</title>
    <link rel="icon" href="../images/logob.png">
    <link rel="stylesheet" href="../admin.css">
</head>

<body>
    <!-- BANNER IMAGE -->
    <div class="banner2">
        <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
        <h1 class="banner-title">YOUR PROFILE</h1>
    </div>

    <div class="container">
        <!-- Left side - Customization options -->
        <div class="customizer">
            <h2>Create your own</h2>

            <form method="post" action="">
                <!-- Size selection -->
                <div class="section-title">Size</div>
                <div class="options-grid">
                    <label class="option-button <?php echo $selectedSize == 'small' ? 'selected' : ''; ?>">
                        <input type="radio" name="size" value="small" style="display: none;" <?php echo $selectedSize == 'small' ? 'checked' : ''; ?>>
                        <div style="text-align: center;">
                            <div style="font-size: 24px;">🌷</div>
                            <div style="font-size: 12px;">Small</div>
                        </div>
                    </label>
                    <label class="option-button <?php echo $selectedSize == 'medium' ? 'selected' : ''; ?>">
                        <input type="radio" name="size" value="medium" style="display: none;" <?php echo $selectedSize == 'medium' ? 'checked' : ''; ?>>
                        <div style="text-align: center;">
                            <div style="font-size: 24px;">🌷</div>
                            <div style="font-size: 12px;">Medium</div>
                        </div>
                    </label>
                    <label class="option-button <?php echo $selectedSize == 'large' ? 'selected' : ''; ?>">
                        <input type="radio" name="size" value="large" style="display: none;" <?php echo $selectedSize == 'large' ? 'checked' : ''; ?>>
                        <div style="text-align: center;">
                            <div style="font-size: 24px;">🌷</div>
                            <div style="font-size: 12px;">Large</div>
                        </div>
                    </label>
                </div>

                <!-- Main Flowers -->
                <div class="section-title">Main Flowers</div>
                <div class="options-grid">
                    <label class="option-button <?php echo $selectedMainFlower == 'rose-red' ? 'selected' : ''; ?>">
                        <input type="radio" name="main_flower" value="rose-red" style="display: none;" <?php echo $selectedMainFlower == 'rose-red' ? 'checked' : ''; ?>>
                        <div style="color: red; font-size: 24px;">🌹</div>
                    </label>
                    <label class="option-button <?php echo $selectedMainFlower == 'lily-white' ? 'selected' : ''; ?>">
                        <input type="radio" name="main_flower" value="lily-white" style="display: none;" <?php echo $selectedMainFlower == 'lily-white' ? 'checked' : ''; ?>>
                        <div style="color: white; font-size: 24px;">🌸</div>
                    </label>
                    <label
                        class="option-button <?php echo $selectedMainFlower == 'orchid-purple' ? 'selected' : ''; ?>">
                        <input type="radio" name="main_flower" value="orchid-purple" style="display: none;" <?php echo $selectedMainFlower == 'orchid-purple' ? 'checked' : ''; ?>>
                        <div style="color: purple; font-size: 24px;">🌺</div>
                    </label>
                    <label
                        class="option-button <?php echo $selectedMainFlower == 'carnation-pink' ? 'selected' : ''; ?>">
                        <input type="radio" name="main_flower" value="carnation-pink" style="display: none;" <?php echo $selectedMainFlower == 'carnation-pink' ? 'checked' : ''; ?>>
                        <div style="color: pink; font-size: 24px;">🌸</div>
                    </label>
                    <label class="option-button <?php echo $selectedMainFlower == 'peony-red' ? 'selected' : ''; ?>">
                        <input type="radio" name="main_flower" value="peony-red" style="display: none;" <?php echo $selectedMainFlower == 'peony-red' ? 'checked' : ''; ?>>
                        <div style="color: red; font-size: 24px;">🌺</div>
                    </label>
                    <label class="option-button <?php echo $selectedMainFlower == 'rose-coral' ? 'selected' : ''; ?>">
                        <input type="radio" name="main_flower" value="rose-coral" style="display: none;" <?php echo $selectedMainFlower == 'rose-coral' ? 'checked' : ''; ?>>
                        <div style="color: coral; font-size: 24px;">🌹</div>
                    </label>
                </div>

                <!-- Fillers -->
                <div class="section-title">Fillers</div>
                <div class="options-grid">
                    <label class="option-button <?php echo $selectedFiller == 'fern1' ? 'selected' : ''; ?>">
                        <input type="radio" name="filler" value="fern1" style="display: none;" <?php echo $selectedFiller == 'fern1' ? 'checked' : ''; ?>>
                        <div style="color: green; font-size: 24px;">🌿</div>
                    </label>
                    <label class="option-button <?php echo $selectedFiller == 'eucalyptus' ? 'selected' : ''; ?>">
                        <input type="radio" name="filler" value="eucalyptus" style="display: none;" <?php echo $selectedFiller == 'eucalyptus' ? 'checked' : ''; ?>>
                        <div style="color: green; font-size: 24px;">🌿</div>
                    </label>
                    <label class="option-button <?php echo $selectedFiller == 'baby-breath' ? 'selected' : ''; ?>">
                        <input type="radio" name="filler" value="baby-breath" style="display: none;" <?php echo $selectedFiller == 'baby-breath' ? 'checked' : ''; ?>>
                        <div style="font-size: 24px;">❀</div>
                    </label>
                    <label class="option-button <?php echo $selectedFiller == 'lavender' ? 'selected' : ''; ?>">
                        <input type="radio" name="filler" value="lavender" style="display: none;" <?php echo $selectedFiller == 'lavender' ? 'checked' : ''; ?>>
                        <div style="font-size: 24px;">❀</div>
                    </label>
                    <label class="option-button <?php echo $selectedFiller == 'grass' ? 'selected' : ''; ?>">
                        <input type="radio" name="filler" value="grass" style="display: none;" <?php echo $selectedFiller == 'grass' ? 'checked' : ''; ?>>
                        <div style="color: green; font-size: 24px;">🌿</div>
                    </label>
                    <label class="option-button <?php echo $selectedFiller == 'fern2' ? 'selected' : ''; ?>">
                        <input type="radio" name="filler" value="fern2" style="display: none;" <?php echo $selectedFiller == 'fern2' ? 'checked' : ''; ?>>
                        <div style="color: green; font-size: 24px;">🌿</div>
                    </label>
                </div>

                <!-- Wrapper -->
                <div class="section-title">Wrapper</div>
                <div class="options-grid">
                    <label class="option-button <?php echo $selectedWrapper == 'black' ? 'selected' : ''; ?>">
                        <input type="radio" name="wrapper" value="black" style="display: none;" <?php echo $selectedWrapper == 'black' ? 'checked' : ''; ?>>
                        <div style="background-color: black; width: 30px; height: 30px; border-radius: 50%;"></div>
                    </label>
                    <label class="option-button <?php echo $selectedWrapper == 'green' ? 'selected' : ''; ?>">
                        <input type="radio" name="wrapper" value="green" style="display: none;" <?php echo $selectedWrapper == 'green' ? 'checked' : ''; ?>>
                        <div style="background-color: green; width: 30px; height: 30px; border-radius: 50%;"></div>
                    </label>
                    <label class="option-button <?php echo $selectedWrapper == 'pink' ? 'selected' : ''; ?>">
                        <input type="radio" name="wrapper" value="pink" style="display: none;" <?php echo $selectedWrapper == 'pink' ? 'checked' : ''; ?>>
                        <div style="background-color: pink; width: 30px; height: 30px; border-radius: 50%;"></div>
                    </label>
                    <label class="option-button <?php echo $selectedWrapper == 'blue' ? 'selected' : ''; ?>">
                        <input type="radio" name="wrapper" value="blue" style="display: none;" <?php echo $selectedWrapper == 'blue' ? 'checked' : ''; ?>>
                        <div style="background-color: lightblue; width: 30px; height: 30px; border-radius: 50%;"></div>
                    </label>
                    <label class="option-button <?php echo $selectedWrapper == 'red' ? 'selected' : ''; ?>">
                        <input type="radio" name="wrapper" value="red" style="display: none;" <?php echo $selectedWrapper == 'red' ? 'checked' : ''; ?>>
                        <div style="background-color: red; width: 30px; height: 30px; border-radius: 50%;"></div>
                    </label>
                    <label class="option-button <?php echo $selectedWrapper == 'purple' ? 'selected' : ''; ?>">
                        <input type="radio" name="wrapper" value="purple" style="display: none;" <?php echo $selectedWrapper == 'purple' ? 'checked' : ''; ?>>
                        <div style="background-color: purple; width: 30px; height: 30px; border-radius: 50%;"></div>
                    </label>
                </div>

                <!-- Ribbon -->
                <div class="section-title">Ribbon</div>
                <div class="options-grid">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <label class="option-button <?php echo $selectedRibbon == 'ribbon-' . $i ? 'selected' : ''; ?>">
                            <input type="radio" name="ribbon" value="ribbon-<?php echo $i; ?>" style="display: none;" <?php echo $selectedRibbon == 'ribbon-' . $i ? 'checked' : ''; ?>>
                            <div style="background-color: pink; width: 40px; height: 20px; position: relative;">
                                <div
                                    style="position: absolute; left: 10px; top: -5px; width: 20px; height: 10px; border-radius: 10px 10px 0 0; background-color: pink;">
                                </div>
                                <div
                                    style="position: absolute; left: 10px; bottom: -5px; width: 20px; height: 10px; border-radius: 0 0 10px 10px; background-color: pink;">
                                </div>
                            </div>
                        </label>
                    <?php endfor; ?>
                </div>

                <!-- Card Message -->
                <div class="section-title">Card</div>
                <textarea class="message-card" name="message"
                    placeholder="Enter your message here..."><?php echo htmlspecialchars($message); ?></textarea>
            </form>
        </div>

        <!-- Right side - Preview -->
        <div class="preview">
            <?php if (isset($cartSuccess)): ?>
                <div style="color: green; text-align: center;">
                    <p>Your custom bouquet has been added to the cart!</p>
                </div>
            <?php else: ?>
                <div style="text-align: center;">
                    <img src="bouquet-preview.jpg" alt="Bouquet Preview" class="bouquet-preview"
                        onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'300\' viewBox=\'0 0 300 300\'><rect width=\'300\' height=\'300\' fill=\'%23f8f8f8\'/><text x=\'50%\' y=\'50%\' font-size=\'18\' text-anchor=\'middle\' fill=\'%23999\'>Bouquet Preview</text></svg>';">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="add-to-cart-container">
        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
    </div>

    <?php include_once 'footer.php'; ?>

    <script>
        // JavaScript to handle the selection UI
        document.addEventListener('DOMContentLoaded', function () {
            const optionButtons = document.querySelectorAll('.option-button');

            optionButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Find the input inside this button
                    const input = this.querySelector('input');
                    input.checked = true;

                    // Remove selected class from other buttons in the same group
                    const groupButtons = document.querySelectorAll(`input[name="${input.name}"]`).forEach(groupInput => {
                        groupInput.closest('.option-button').classList.remove('selected');
                    });

                    // Add selected class to this button
                    this.classList.add('selected');
                });
            });
        });
    </script>
</body>

</html>