<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> SakhiBazaar. All rights reserved.</p>
</footer>
</main> <!-- closing .main-content if opened in header -->
</body>
</html>
<style>
  .footer {
    width: 100%;
        /* Limit width for large screens */
    margin: 2rem auto 0;      /* Top space, center horizontally */
    padding: 1rem;
    background-color: #f8f9fa;
    text-align: center;
    font-size: 0.9rem;
    color: #333;
    border-top: 1px solid #e0e0e0;
    box-sizing: border-box;
  }

  @media (max-width: 600px) {
    .footer {
      font-size: 0.85rem;
      padding: 1rem 0.5rem;
      margin: 1.5rem auto 0; /* Slightly smaller top margin for mobile */
    }
  }
</style>
