<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Su<!DOCTYPE html>
ccess Stories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(#EDE4F0);
    }

    .main-content {
      padding: 20px;
      max-width: 900px;
      margin: 0 auto;
    }

    .success-stories h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .resource-card {
      background: #fff;
      display: flex;
      flex-direction: row;
      align-items: flex-start;
      gap: 20px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      margin-bottom: 20px;
    }

    .resource-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .resource-card img {
      width: 180px;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
      flex-shrink: 0;
    }

    .card-content {
      flex: 1;
    }

    .card-content h3 {
      margin: 0 0 8px;
      font-size: 1.2rem;
      color: #7e22ce;
    }

    .card-content .story-summary {
      font-size: 0.95rem;
      color: #555;
      margin-bottom: 8px;
    }

    .card-content .location {
      font-size: 0.85rem;
      color: #777;
      margin-bottom: 10px;
    }

    .card-content .read-more {
      text-decoration: none;
      color: #7e22ce;
      font-weight: 500;
      font-size: 0.9rem;
      transition: color 0.2s ease;
    }

    .card-content .read-more:hover {
      color: #5b21b6;
    }

    @media (max-width: 768px) {
      .resource-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .resource-card img {
        width: 100%;
        height: auto;
      }

      .card-content {
        text-align: left;
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="main-content">
    <section class="success-stories">
      <h2>Success Stories</h2>

      <div class="resource-card">
        <img src="https://images.pexels.com/photos/5996804/pexels-photo-5996804.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Rani Devi">
        <div class="card-content">
          <h3>Rani Devi</h3>
          <p class="story-summary">
            Rani started a home-based pickle business with just a few jars. Today, she supplies local stores and has inspired other women to start small.
          </p>
          <p class="location"><strong>Location:</strong> Bihar</p>
          <a href="#" class="read-more">Read More →</a>
        </div>
      </div>

      <div class="resource-card">
        <img src="https://via.placeholder.com/180x150?text=Savita+Kumari" alt="Savita Kumari">
        <div class="card-content">
          <h3>Savita Kumari</h3>
          <p class="story-summary">
            Savita used her tailoring skills to launch a clothing line from home. Her designs are now featured in local exhibitions.
          </p>
          <p class="location"><strong>Location:</strong> Uttar Pradesh</p>
          <a href="#" class="read-more">Read More →</a>
        </div>
      </div>

      <div class="resource-card">
        <img src="https://via.placeholder.com/180x150?text=Meena+Patel" alt="Meena Patel">
        <div class="card-content">
          <h3>Meena Patel</h3>
          <p class="story-summary">
            Starting with handmade bamboo products, Meena’s creations are now sold through Sakhi Bazaar and local craft fairs.
          </p>
          <p class="location"><strong>Location:</strong> Gujarat</p>
          <a href="#" class="read-more">Read More →</a>
        </div>
      </div>

      <div class="resource-card">
        <img src="https://via.placeholder.com/180x150?text=Kavita+Joshi" alt="Kavita Joshi">
        <div class="card-content">
          <h3>Kavita Joshi</h3>
          <p class="story-summary">
            Kavita turned her family’s dairy farm into a cooperative, helping over 50 women earn sustainable income in the hills.
          </p>
          <p class="location"><strong>Location:</strong> Uttarakhand</p>
          <a href="#" class="read-more">Read More →</a>
        </div>
      </div>

      <div class="resource-card">
        <img src="https://images.pexels.com/photos/7919428/pexels-photo-7919428.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Pushpa Rani">
        <div class="card-content">
          <h3>Pushpa Rani</h3>
          <p class="story-summary">
            With minimal resources, Pushpa began making natural soaps. Her business has grown to serve customers in three districts.
          </p>
          <p class="location"><strong>Location:</strong> Rajasthan</p>
          <a href="#" class="read-more">Read More →</a>
        </div>
      </div>

      <div class="resource-card">
        <img src="https://via.placeholder.com/180x150?text=Shanti+Bai" alt="Shanti Bai">
        <div class="card-content">
          <h3>Shanti Bai</h3>
          <p class="story-summary">
            Shanti revived traditional embroidery techniques and trained girls in her village, preserving art and creating jobs.
          </p>
          <p class="location"><strong>Location:</strong> Madhya Pradesh</p>
          <a href="#" class="read-more">Read More →</a>
        </div>
      </div>

    </section>
  </div>
   <script src = "js/script.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>