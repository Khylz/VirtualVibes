// // Fonction pour initialiser l'animation
// function initAnimation() {
//     var textWrapper = document.querySelector('.txtjs');
//     if (textWrapper) {
//       textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
  
//       anime.timeline({loop: true})
//         .add({
//           targets: '.txtjs .letter',
//           opacity: [0, 1],
//           easing: "easeInOutQuad",
//           duration: 2250,
//           delay: (el, i) => 150 * (i + 1)
//         }).add({
//           targets: '.txtjs',
//           opacity: 0,
//           duration: 1000,
//           easing: "easeOutExpo",
//           delay: 1000
//         });
//     }
//   }
  
//   // Réinitialiser les événements au chargement dynamique de contenu
//   document.querySelectorAll('.rubrik-link').forEach(link => {
//     link.addEventListener('click', function(e) {
//       e.preventDefault();
//       const url = this.href;
  
//       fetch(url)
//         .then(response => response.text())
//         .then(html => {
//           document.querySelector('.container').innerHTML = html;
  
//           // Réattacher les écouteurs d'événements et relancer l'animation
//           initAnimation();
//         })
//         .catch(error => console.warn('Erreur lors du chargement du contenu', error));
//     });
//   });
  
//   // Lancer l'animation au chargement initial
//   initAnimation();