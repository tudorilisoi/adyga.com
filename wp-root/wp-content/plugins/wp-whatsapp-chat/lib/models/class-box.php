<?php
namespace QuadLayers\QLWAPP\Models;

use QuadLayers\QLWAPP\Entities\Box as Box_Entity;

use QuadLayers\WP_Orm\Builder\SingleRepositoryBuilder;

class Box {

	/**
	 * Box fields the frontend renders as HTML.
	 */
	const HTML_FIELDS = array( 'header', 'footer', 'consent_message' );

	/**
	 * Box fields backed by a yes/no control.
	 */
	const TOGGLE_FIELDS = array( 'enable', 'auto_open', 'lazy_load', 'allow_outside_close', 'consent_enabled' );

	protected static $instance;
	protected $repository;

	public function __construct() {
		add_filter( 'sanitize_option_qlwapp_box', 'wp_unslash' );
		$builder = ( new SingleRepositoryBuilder() )
		->setTable( 'qlwapp_box' )
		->setEntity( Box_Entity::class );

		$this->repository = $builder->getRepository();
	}

	public function get_table() {
		return $this->repository->getTable();
	}

	public function get() {
		$entity = $this->repository->find();
		$result = null;

		if ( $entity ) {
			$result = $entity->getProperties();
		} else {
			$admin  = new Box_Entity();
			$result = $admin->getProperties();
		}

		// Only replace variables on frontend (not in admin or REST API admin requests).
		$is_rest_admin = defined( 'REST_REQUEST' ) && REST_REQUEST && is_user_logged_in();
		if ( ! is_admin() && ! $is_rest_admin ) {
			$result['header'] = qlwapp_replacements_vars( $result['header'] );
			$result['footer'] = qlwapp_replacements_vars( $result['footer'] );
		}

		return $result;
	}

	public function delete_all() {
		return $this->repository->delete();
	}

	public function save( $data ) {
		$entity = $this->repository->create( $this->sanitize( $data ) );

		if ( $entity ) {
			return true;
		}
	}

	public function sanitize( $settings ) {
		foreach ( self::HTML_FIELDS as $field ) {
			if ( isset( $settings[ $field ] ) ) {
				$settings[ $field ] = is_string( $settings[ $field ] ) ? wp_kses_post( $settings[ $field ] ) : '';
			}
		}

		foreach ( self::TOGGLE_FIELDS as $field ) {
			if ( isset( $settings[ $field ] ) ) {
				/*
				 * The admin controls post 'yes'/'no', but external callers
				 * (QLWAPP_PRO, filters) may hand over the boolean equivalents.
				 * Read those as enabled instead of silently turning the
				 * setting off.
				 */
				$settings[ $field ] = in_array( $settings[ $field ], array( 'yes', true, 1, '1' ), true ) ? 'yes' : 'no';
			}
		}

		if ( isset( $settings['response'] ) ) {
			$settings['response'] = is_string( $settings['response'] ) ? sanitize_text_field( $settings['response'] ) : '';
		}

		if ( isset( $settings['auto_delay_open'] ) ) {
			// An empty control means "no delay set" — absint() would store it as 0.
			$settings['auto_delay_open'] = '' === $settings['auto_delay_open'] ? '' : absint( $settings['auto_delay_open'] );
		}

		return $settings;
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
