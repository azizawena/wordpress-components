<?php
/**
 * Plugin Name: Portfolio Projects
 * Description: CPT genérico de projetos para estudos de arquitetura de conteúdo em WordPress.
 * Version: 0.1.0
 * Author: Alessandra de Mattos
 * License: GPL-2.0-or-later
 * Text Domain: portfolio-projects
 */

defined( 'ABSPATH' ) || exit;

function adm_register_portfolio_project_cpt() {
    $labels = array(
        'name'               => __( 'Projetos', 'portfolio-projects' ),
        'singular_name'      => __( 'Projeto', 'portfolio-projects' ),
        'add_new_item'       => __( 'Adicionar novo projeto', 'portfolio-projects' ),
        'edit_item'          => __( 'Editar projeto', 'portfolio-projects' ),
        'new_item'           => __( 'Novo projeto', 'portfolio-projects' ),
        'view_item'          => __( 'Ver projeto', 'portfolio-projects' ),
        'search_items'       => __( 'Buscar projetos', 'portfolio-projects' ),
        'not_found'          => __( 'Nenhum projeto encontrado', 'portfolio-projects' ),
        'not_found_in_trash' => __( 'Nenhum projeto na lixeira', 'portfolio-projects' ),
    );

    register_post_type(
        'portfolio_project',
        array(
            'labels'       => $labels,
            'public'       => true,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-portfolio',
            'has_archive'  => true,
            'rewrite'      => array( 'slug' => 'projetos' ),
            'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        )
    );
}

function adm_register_project_discipline_taxonomy() {
    register_taxonomy(
        'project_discipline',
        array( 'portfolio_project' ),
        array(
            'label'        => __( 'Disciplinas', 'portfolio-projects' ),
            'public'       => true,
            'show_in_rest' => true,
            'hierarchical' => false,
            'rewrite'      => array( 'slug' => 'disciplina' ),
        )
    );
}

function adm_portfolio_projects_init() {
    adm_register_portfolio_project_cpt();
    adm_register_project_discipline_taxonomy();
}
add_action( 'init', 'adm_portfolio_projects_init' );

function adm_portfolio_projects_activate() {
    adm_portfolio_projects_init();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'adm_portfolio_projects_activate' );

function adm_portfolio_projects_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'adm_portfolio_projects_deactivate' );
