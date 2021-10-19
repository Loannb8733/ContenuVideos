<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'wordpress' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'A>2r10*7JX4qw5q*#t&4sDgVoRZFcY;@J|Fdo;HR@D; 0D.f RJ}4]c?m{-Dd.1=' );
define( 'SECURE_AUTH_KEY',  'T&;K9LMP]pQ$U2ZKuHp;o6.=JgN:bf!1_=|xWeo$<Umek/f6 7$CzIbm-b!n#$Fu' );
define( 'LOGGED_IN_KEY',    '31?*T&i@qHif9Hp=EnM_-s)m{24bS36~aYilgfJ$y/W8d0@D;#QP-z)n^n.#P88_' );
define( 'NONCE_KEY',        '6woD0<5^X@R#ZV>opFY1~{K/?-n,hyD-lKGmu+<AYC0}OuD6)C/^f$oikW-pV/tl' );
define( 'AUTH_SALT',        'S82g}ELx?K+RF[vb4+~}d2|EQfjJ*t4E$:4j.SaOu}UgG;YD?8EWi[aoXL1!],f`' );
define( 'SECURE_AUTH_SALT', 'WS{jtN*8][UK y$i Uc5Epx#}K`o_Lg2v<]F:sVCA~CDC((Z3_$k+R=]1F%O&08E' );
define( 'LOGGED_IN_SALT',   '|*|L57PoC;hleNIq;mjViXI-}?Dj6##>B8|igY]L^Ix.(<RA0=L){wpi|h6ySH =' );
define( 'NONCE_SALT',       'aP2`s7J-q!BxX_]G:~/`7I<Yu4dM2?JjNUWl*6ts|%gV8jI6Wc&[l>8Cnw2ukp+1' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
