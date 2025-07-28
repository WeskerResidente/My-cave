/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import './js/swipper.js';
import './js/filtre.js';
import './js/Ajax-show.js';
import './js/stars.js';

// console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
//                 <form method="POST"
//             action="{{ path('app_toggle_visibilite_cave', { id: cave.id }) }}"
//             class="form-toggle-privee">
//         <input type="hidden" name="_token" value="{{ csrf_token('toggle-cave-' ~ cave.id) }}">
//           <button type="submit" class="btn-toggle-privee">
//             {% if cave.isPrivee %}
//               🔓 Rendre publique
//             {% else %}
//               🔒 Rendre privée
//             {% endif %}
//           </button>
//       </form>
//           </div>