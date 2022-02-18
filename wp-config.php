<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'XXXXX' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'XXXXX' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'XXXXXX' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'XXXXXX' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ua=]$.;Qb1Yi/!Dug(25F/&HIK1uqeN~k$c@=+VX!zDd?]PT?;ly9^nI2*4I<xn#' );
define( 'SECURE_AUTH_KEY',  'bmr62*<p~!Kjj9&_.&vzDebI cFxJC)#iO$$a*~&k{GEdTg&-I>ee18m2_H~H&eY' );
define( 'LOGGED_IN_KEY',    'T935oNm]Y0^M5JOK6)z5e)}^k.*N=T)}pfUE4rT>|g@/65!dnr5ApOW^=bso3_lU' );
define( 'NONCE_KEY',        'iS#rc4ot&MLs_OI:P~5J8gx]HHf,j8m]PkH3oUSq{7w#b$IjS21*enq.I?&nCs;S' );
define( 'AUTH_SALT',        'u#APbJX]E>{1TWE2Q!8PT[aNIqI@fve|)]ZFu0@aM9|R)]wf6~uw^Ghd|{0j>0[y' );
define( 'SECURE_AUTH_SALT', 'g)?8ae$m_4lu:A0b$~etuQWkQ0rO/rm%i%6#(oK~9-G~GnXb/F@H.GHcovkk89k6' );
define( 'LOGGED_IN_SALT',   'qG8M5  va=ltGE+9|-.qF^P!g$%C`!Qn*l;ObxsZ0W ;UUcl*z D}7APM)4iAT|l' );
define( 'NONCE_SALT',       'N*Bdl!{T_O*rwanc=|(3w+p<LMe}Ii|p!pB+MTWVWJe7yp-r@4Z9{^u8.>HtDvJg' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';










/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
