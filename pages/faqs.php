<?php
require_once 'header.php';
require_once '../connection.php';

$sql = "SELECT * FROM faqs";
$faq = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <link rel="icon" href="images/logob.png">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <!-- BANNER IMAGE -->
    <div class="banner2">
        <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
        <form action="searchCoffee.inc.php" method="GET" class="search-form">
            <input type="text" class="search-bar" name="query" placeholder="Search">
        </form>
    </div>

    <div class="faq-desc">
        <h2><strong>Frequently Asked Questions</strong></h2>
        <h4>Lorem ipsum dolor sit amet. Qui quaerat natus ea molestiae enim et vitae dolorem. Qui incidunt reiciendis ut
            beatae </h4>
    </div>

    <div class="faqs-container">
        <?php
        $faqCategories = [
            [
                'title' => 'General Questions',
                'questions' => [
                    [
                        'question' => 'What are your business hours?',
                        'answer' => 'We are open from 9am - 5pm on weekdays. You can also place orders online 24/7.'
                    ],
                    [
                        'question' => 'Where is your shop located?',
                        'answer' => 'Our shop is located at Maysan, Valenzuela City. '
                    ],
                    [
                        'question' => 'Do you offer same-day delivery?',
                        'answer' => 'Yes! We offer same-day delivery for orders placed before 3pm.'
                    ],
                    [
                        'question' => 'How can I contact customer service?',
                        'answer' => 'You can reach us via email at bloomboutique@gmail.com, call us at 09123456789'
                    ]
                ]
            ],
            [
                'title' => 'Ordering and Payment',
                'questions' => [
                    [
                        'question' => 'How do I place an order?',
                        'answer' => 'You can order online through our website by selecting your preferred flowers, adding them to your cart, and proceeding to checkout.'
                    ],
                    [
                        'question' => 'What payment methods do you accept?',
                        'answer' => 'We accept [credit/debit cards, PayPal, Apple Pay, Google Pay, and cash on delivery (if applicable)].'
                    ],
                    [
                        'question' => 'Can I modify or cancel my order after placing it?',
                        'answer' => 'Yes, but changes or cancellations must be made at least [insert time frame] before delivery. Please contact us as soon as possible.'
                    ],
                    [
                        'question' => 'Do you offer refunds or exchanges?',
                        'answer' => 'We offer refunds or replacements for damaged flowers. Please contact us within [insert time frame] with photos for verification.'
                    ],
                    [
                        'question' => 'Can I request a custom bouquet or floral arrangement?',
                        'answer' => 'Absolutely! We offer custom floral designs. Contact us with your preferences, and we’ll create something special for you.'
                    ]
                ]
            ],
            [
                'title' => 'Delivery and Shipping',
                'questions' => [
                    [
                        'question' => 'Do you deliver outside of [City/Region]?',
                        'answer' => 'Currently, we deliver within [list areas]. For deliveries outside these areas, please contact us.'
                    ],
                    [
                        'question' => 'How much does delivery cost?',
                        'answer' => 'Delivery fees vary based on location. You can check the fee at checkout or contact us for details.'
                    ],
                    [
                        'question' => 'What happens if the recipient is not available at the time of delivery?',
                        'answer' => 'We will attempt to contact the recipient. If unavailable, we may leave the flowers with a neighbor, at a safe location, or reschedule the delivery.'
                    ],
                    [
                        'question' => 'Can I schedule a delivery for a specific date and time?',
                        'answer' => 'Yes! During checkout, you can choose a preferred date and time for delivery.'
                    ],
                    [
                        'question' => 'Do you provide international shipping?',
                        'answer' => 'Currently, we do not offer international shipping, but we hope to in the future!'
                    ]
                ]
            ],
            [
                'title' => 'Flowers and Care',
                'questions' => [
                    [
                        'question' => 'How long will my flowers stay fresh?',
                        'answer' => 'Our flowers typically last [5-7 days] with proper care.'
                    ],
                    [
                        'question' => 'Do you offer flower care tips?',
                        'answer' => 'Yes! Here are some general tips:
                                    Trim the stems at an angle before placing them in water.
                                    Change the water every 2 days.
                                    Keep flowers away from direct sunlight and heat sources.'
                    ],
                    [
                        'question' => 'Are your flowers locally sourced?',
                        'answer' => 'We source our flowers from both local farms and trusted suppliers to ensure the best quality.'
                    ],
                    [
                        'question' => 'Do you sell potted plants or only cut flowers?',
                        'answer' => 'Yes! We offer a variety of potted plants alongside our fresh-cut flowers.'
                    ],
                    [
                        'question' => 'Are your flowers pesticide-free or organic?',
                        'answer' => 'We prioritize eco-friendly practices and work with suppliers who follow sustainable growing methods.'
                    ]
                ]
            ],
            [
                'title' => 'Special Occasions and Services',
                'questions' => [
                    [
                        'question' => 'Do you offer floral arrangements for weddings or corporate events?',
                        'answer' => 'Yes! We provide floral designs for weddings, corporate events, and other special occasions. Contact us for a consultation.'
                    ],
                    [
                        'question' => 'Can I set up a flower subscription service?',
                        'answer' => 'Yes! We offer weekly, bi-weekly, or monthly flower subscriptions. Sign up for a plan that suits you.'
                    ],
                    [
                        'question' => 'Do you provide funeral or sympathy flowers?',
                        'answer' => 'Yes, we offer arrangements for funerals and sympathy occasions. Please contact us for custom requests.'
                    ],
                    [
                        'question' => 'Can you include a message card with my order?',
                        'answer' => 'Absolutely! You can add a personalized message at checkout, and we will include it with your bouquet.'
                    ],
                    [
                        'question' => 'Do you offer discounts for bulk or corporate orders?',
                        'answer' => 'Yes! We provide discounts for bulk orders. Contact us for pricing and custom arrangements.'
                    ]
                ]
            ]
        ];

        // Generate HTML for FAQ categories and questions
        foreach ($faqCategories as $index => $category) {
            echo '<div class="faq-category">';
            echo '<div class="category-header" data-category="category-' . $index . '">';
            echo '<h3>' . $category['title'] . '</h3>';
            echo '<span class="category-icon">▼</span>';
            echo '</div>';

            echo '<div class="category-content">';

            foreach ($category['questions'] as $qIndex => $questionData) {
                echo '<div class="faq-question">';
                echo '<div class="question-header" data-question="question-' . $index . '-' . $qIndex . '">';
                echo '<div>' . $questionData['question'] . '</div>';
                echo '<span class="question-icon">▼</span>';
                echo '</div>';

                echo '<div class="question-content">';
                echo '<p>' . $questionData['answer'] . '</p>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>'; // End category-content
            echo '</div>'; // End faq-category
        }
        ?>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add click event for category headers
            const categoryHeaders = document.querySelectorAll('.category-header');
            categoryHeaders.forEach(header => {
                header.addEventListener('click', function () {
                    const categoryId = this.getAttribute('data-category');
                    const categoryElement = this.parentElement;

                    // Toggle active class for clicked category
                    categoryElement.classList.toggle('category-active');

                    // Close other categories
                    categoryHeaders.forEach(otherHeader => {
                        const otherCategoryId = otherHeader.getAttribute('data-category');
                        if (otherCategoryId !== categoryId) {
                            otherHeader.parentElement.classList.remove('category-active');
                        }
                    });
                });
            });

            // Add click event for question headers
            const questionHeaders = document.querySelectorAll('.question-header');
            questionHeaders.forEach(header => {
                header.addEventListener('click', function (e) {
                    // Prevent event bubbling to category
                    e.stopPropagation();

                    const questionId = this.getAttribute('data-question');
                    const questionElement = this.parentElement;

                    // Toggle active class for clicked question
                    questionElement.classList.toggle('question-active');

                    // Close other questions within the same category
                    const categoryQuestions = questionElement.parentElement.querySelectorAll('.faq-question');
                    categoryQuestions.forEach(otherQuestion => {
                        if (otherQuestion !== questionElement) {
                            otherQuestion.classList.remove('question-active');
                        }
                    });
                });
            });
        });
    </script>
    <?php include_once 'footer.php'; ?>
</body>

</html>