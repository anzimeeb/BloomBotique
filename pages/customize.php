<?php
include_once 'header.php';
include 'functionsPages.inc.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Custom Bouquet</title>
    <link rel="stylesheet" href="styles.css"> <!-- Make sure this file exists -->
</head>

<body>
    <form method="POST" action="customize.inc.php">
        <div class="container">

            <!-- Left side - Form -->
            <div class="form-area">
                <!-- Size -->
                <div class="section-title">Size</div>
                <div class="scrollable-options" id="size-options">
                    <label class="option-button">
                        <input type="radio" name="size" value="Small"> Small
                    </label>
                    <label class="option-button">
                        <input type="radio" name="size" value="Medium"> Medium
                    </label>
                    <label class="option-button">
                        <input type="radio" name="size" value="Large"> Large
                    </label>
                </div>

                <!-- Main Flowers -->
                <div class="section-title">Main Flowers</div>
                <div class="scrollable-options" id="main-flower-options">
                    <label class="option-button">
                        🌹 Red Rose
                        <input type="number" name="main_flower[Rose/IMG_0599]" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌷 Pink Tulip
                        <input type="number" name="main_flower[Tulips/IMG_0620]" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌻 Sunflower
                        <input type="number" name="main_flower[SunfloweR/IMG_0624]" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌼 Daisy
                        <input type="number" name="main_flower[Daisies/IMG_0629]" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌺 Gerbera
                        <input type="number" name="main_flower[Gerberas/IMG_0633]" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌸 Lilies
                        <input type="number" name="main_flower[Lilies/IMG_0631]" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌸 Peonies
                        <input type="number" name="main_flower[Peonies/IMG_0627" min="0" value="0">
                    </label>
                    <label class="option-button">
                        🌟 Stargazer
                        <input type="number" name="main_flower[Stargazer/IMG_0622]" min="0" value="0">
                    </label>
                </div>

                <!-- Ribbon -->
                <div class="section-title">Ribbon</div>
                <div class="options-grid scrollable-options" id="ribbon-options">
                    <label class="option-button">
                        <input type="radio" name="ribbon" value="None">
                        🚫 None
                    </label>
                    <label class="option-button">
                        <input type="radio" name="ribbon" value="Satin.png">
                        ❤️ Satin
                    </label>
                    <label class="option-button">
                        <input type="radio" name="ribbon" value="Patterned.png">
                        💙 Patterned
                    </label>
                    <label class="option-button">
                        <input type="radio" name="ribbon" value="Grossgrain_.png">
                        💙 Gross Grain
                    </label>
                </div>

                <!-- Wrapper -->
                <div class="section-title">Wrapper</div>
                <div class="options-grid scrollable-options" id="wrapper-options">
                    <label class="option-button">
                        <input type="radio" name="wrapper" value="B.png">
                        💙 Blue Wrapper
                    </label>
                    <label class="option-button">
                        <input type="radio" name="wrapper" value="P.png">
                        🩷 Pink Wrapper
                    </label>
                    <label class="option-button">
                        <input type="radio" name="wrapper" value="B1.png">
                        🖤 Black Wrapper
                    </label>
                    <label class="option-button">
                        <input type="radio" name="wrapper" value="G.png">
                        💚 Green Wrapper
                    </label>
                    <label class="option-button">
                        <input type="radio" name="wrapper" value="R.png">
                        ❤️ Red Wrapper
                    </label>
                    <label class="option-button">
                        <input type="radio" name="wrapper" value="V.png">
                        💜 Violet Wrapper
                    </label>
                </div>

                <!-- Fillers -->
                <div class="section-title">Fillers</div>
                <div class="options-grid scrollable-options" id="filler-options">
                    <label class="option-button">
                        <input type="radio" name="filler" value="None">
                        🚫 None
                    </label>
                    <label class="option-button">
                        <input type="radio" name="filler" value="Babysbreath.png">
                        🌿 Baby's Breath
                    </label>
                    <label class="option-button">
                        <input type="radio" name="filler" value="Eucalyptus_.png">
                        🌿 Eucalyptus
                    </label>
                    <label class="option-button">
                        <input type="radio" name="filler" value="Lavender.png">
                        🌿 Lavender
                    </label>
                    <label class="option-button">
                        <input type="radio" name="filler" value="QueenAnneslace.png">
                        🌿 Queen Anne's Lace
                    </label>
                    <label class="option-button">
                        <input type="radio" name="filler" value="Asters.png">
                        🌿 Asters
                    </label>
                </div>

                <!-- Card -->
                <div class="section-title">Card</div>
                <textarea class="message-card" name="card"
                    placeholder="Enter your message here..."><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>

                <!-- Add to Cart -->
                <div class="add-to-cart-container">
                    <button type="submit" name="save_customflower" class="add-to-cart">Add to Cart</button>
                </div>

            </div>


            <!-- Right side - Preview -->
            <div class="preview">
                <div id="preview" style="margin-top: 20px;">
                    <h4>Live Preview:</h4>
                    <div id="main-flower-preview">
                        <!-- Images will be stacked here -->
                    </div>
                </div>
            </div>

        </div>
    </form>

    <?php include_once 'footer.php'; ?>

    <script>
        function updatePreview() {
            const flowerInputs = document.querySelectorAll('input[name^="main_flower["]');
            const previewDiv = document.getElementById("main-flower-preview");
            const filler = document.querySelector('input[name="filler"]:checked')?.value;
            const ribbon = document.querySelector('input[name="ribbon"]:checked')?.value;
            const wrapper = document.querySelector('input[name="wrapper"]:checked')?.value;

            previewDiv.innerHTML = ""; // Clear previous preview

            // Add wrapper first (background)
            if (wrapper) {
                let wrapperImg = document.createElement('img');
                wrapperImg.src = "../images/customize/BOUQUETS/" + wrapper;
                wrapperImg.alt = "Wrapper";
                wrapperImg.style.position = "absolute";
                wrapperImg.style.top = "0";
                wrapperImg.style.left = "0";
                wrapperImg.style.width = "100%";
                wrapperImg.style.height = "100%";
                wrapperImg.style.zIndex = "1"; // Background layer
                previewDiv.appendChild(wrapperImg);
            }

            // Add main flowers
            // Add a flower container inside the previewDiv
            let flowerAreaDiv = document.createElement('div');
            flowerAreaDiv.style.position = "absolute";
            flowerAreaDiv.style.top = "20%";    // Adjust to your preferred "flower area"
            flowerAreaDiv.style.left = "30%";
            flowerAreaDiv.style.width = "40%";
            flowerAreaDiv.style.height = "40%";
            flowerAreaDiv.style.zIndex = "2";
            flowerAreaDiv.style.pointerEvents = "none"; // Flowers won't block clicks
            previewDiv.appendChild(flowerAreaDiv);

            // Add main flowers
            flowerInputs.forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    const flowerName = input.name.match(/\[(.*?)\]/)[1];

                    for (let i = 0; i < quantity; i++) {
                        let flowerImg = document.createElement('img');
                        flowerImg.src = "../images/customize/FLOWERS/" + flowerName + ".png";
                        flowerImg.alt = flowerName;
                        flowerImg.style.position = "absolute";
                        flowerImg.style.top = Math.random() * 80 + "%";   // Random inside container
                        flowerImg.style.left = Math.random() * 80 + "%";  // Random inside container
                        flowerImg.style.transform = `translate(-50%, -50%) rotate(${Math.random() * 30 - 15}deg)`; // Center & random rotate
                        flowerImg.style.width = "60%"; // Slightly smaller maybe
                        flowerImg.style.height = "auto";
                        flowerImg.style.zIndex = "2";
                        flowerAreaDiv.appendChild(flowerImg);
                    }
                }
            });

            // Add fillers (after main flowers but before ribbon)
            if (filler) {
                let fillerImg = document.createElement('img');
                fillerImg.src = "../images/customize/FILLERS/" + filler; // Assuming filler image filenames
                fillerImg.alt = filler;
                fillerImg.style.position = "absolute";
                fillerImg.style.top = "20%";
                fillerImg.style.left = "20%";
                fillerImg.style.width = "40%"; // Maybe slightly smaller than main flowers
                fillerImg.style.height = "40%";
                fillerImg.style.margin = "auto";
                fillerImg.style.zIndex = "2"; // Same layer as flowers
                previewDiv.appendChild(fillerImg);
            }

            // Add ribbon last (foreground)
            if (ribbon) {
                let ribbonImg = document.createElement('img');
                ribbonImg.src = "../images/customize/RIBBONS/" + ribbon;
                ribbonImg.alt = "Ribbon";
                ribbonImg.style.position = "absolute";
                ribbonImg.style.bottom = "34px";
                ribbonImg.style.left = "50%";
                ribbonImg.style.transform = "translateX(-55%)";
                ribbonImg.style.width = "50%";
                ribbonImg.style.height = "auto";
                ribbonImg.style.zIndex = "3"; // Foreground ribbon
                previewDiv.appendChild(ribbonImg);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Handle radio clicks (ribbon, wrapper, size)
            document.querySelectorAll('.option-button input[type="radio"]').forEach(input => {
                input.addEventListener('change', function () {
                    // Mark selected visually
                    document.querySelectorAll(`input[name="${this.name}"]`).forEach(groupInput => {
                        groupInput.closest('.option-button').classList.remove('selected');
                    });
                    this.closest('.option-button').classList.add('selected');

                    updatePreview(); // <-- Important: Update preview after radio change
                });
            });

            // Handle number input changes (main flowers)
            document.querySelectorAll('.option-button input[type="number"]').forEach(input => {
                input.addEventListener('input', function (e) {
                    if (parseInt(this.value) > 0) {
                        this.closest('.option-button').classList.add('selected');
                    } else {
                        this.closest('.option-button').classList.remove('selected');
                    }
                    updatePreview(); // <-- Update preview whenever flower quantity changes
                });

                // Also allow clicking the whole button to select/deselect
                input.closest('.option-button').addEventListener('click', function (e) {
                    if (e.target.tagName !== 'INPUT') { // Ignore direct number input clicks
                        const numberInput = this.querySelector('input[type="number"]');
                        if (parseInt(numberInput.value) > 0) {
                            numberInput.value = 0;
                            this.classList.remove('selected');
                        } else {
                            numberInput.value = 1;
                            this.classList.add('selected');
                        }
                        updatePreview();
                    }
                });
            });
        });

        // Keep your working scroll behavior
        document.querySelectorAll('.scrollable-options').forEach(container => {
            container.addEventListener('wheel', function (e) {
                if (e.deltaY > 0) {
                    container.scrollBy({ left: 100, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: -100, behavior: 'smooth' });
                }
                e.preventDefault();
            });
        });

        // This will run every time the size is changed OR a flower quantity is changed
        function setupMainFlowerLimits() {
            const flowerInputs = document.querySelectorAll('input[name^="main_flower["]');
            const sizeInputs = document.querySelectorAll('input[name="size"]');

            function getMaxFlowers() {
                const selectedSize = document.querySelector('input[name="size"]:checked')?.value || 'Small';
                if (selectedSize === 'Medium') return 12;
                if (selectedSize === 'Large') return 20;
                return 6; // Default is Small
            }

            function enforceFlowerLimit(changedInput = null) {
                const maxFlowers = getMaxFlowers();
                let total = 0;

                flowerInputs.forEach(input => {
                    total += parseInt(input.value) || 0;
                });

                if (total > maxFlowers && changedInput) {
                    const overBy = total - maxFlowers;
                    let newValue = (parseInt(changedInput.value) || 0) - overBy;
                    changedInput.value = Math.max(0, newValue);
                    alert(`You can only select up to ${maxFlowers} main flowers for this size.`);
                }

                updatePreview(); // Update bouquet preview
            }

            // Listen to changes on each flower input
            flowerInputs.forEach(input => {
                input.addEventListener('input', function () {
                    enforceFlowerLimit(this);
                });
            });

            // Also listen to size change and re-check limits
            sizeInputs.forEach(input => {
                input.addEventListener('change', function () {
                    enforceFlowerLimit();
                });
            });
        }

        // Call it once when the page loads
        setupMainFlowerLimits();

    </script>

</body>

</html>