<?php
/**
 * Mathematic protector class
 *
 * @package TorroForms
 * @since 1.0.0
 */

namespace awsmug\TorroFormsProtectorsPlus\Protectors;

use awsmug\Torro_Forms\DB_Objects\Forms\Form;
use awsmug\Torro_Forms\DB_Objects\Submissions\Submission;
use awsmug\Torro_Forms\Modules\Protectors\Protector;
use WP_Error;

/**
 * Class for a protector using easy mathematic tasks.
 *
 * @since 1.0.0
 */
class Mathematics extends Protector { // @codingStandardsIgnoreLine

	/**
	 * Bootstraps the submodule by setting properties.
	 *
	 * @since 1.0.0
	 */
	protected function bootstrap() {
		$this->slug  = 'mathematic';
		$this->title = __( 'Mathematic', 'torro-forms-protectors-plus' );
	}

	/**
	 * Verifies a request by ensuring that it is not spammy.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Submission POST data.
	 * @param Form $form Form object.
	 * @param Submission|null $submission Submission object, or null if a new submission.
	 *
	 * @return bool|WP_Error True if request is not spammy, false or error object otherwise.
	 */
	public function verify_request( $data, $form, $submission = null ) {
		$math = $_POST['protector_mathematics'];

		$num_1 = (float) $math['num_1'];
		$num_2 = (float) $math['num_2'];
		$entered = (float) $math['result'];

		 if ( empty( $entered ) ) { // phpcs:ignore WordPress.Security
			 return new WP_Error( 'protector_mathematics_missing_input', __( 'Missing mathematics question input. Please check the question to verify you are human.', 'torro-forms-protectors-plus' ) );
		 }

		$type  = $this->get_form_option( $form->id, 'type', 'add' );

		$expected = $this->calculate( $num_1, $num_2, $type );

		if ( $expected !== $entered ) {
			return new WP_Error( 'protector_mathematics_wrong_entered', __( 'Answer on mathematics question is wrong. Please check the question to verify you are human.', 'torro-forms-protectors-plus' ) );
		}

		return true;
	}

	/**
	 * Renders the output for the protector before the Submit button.
	 *
	 * @since 1.0.0
	 *
	 * @param Form $form Form object.
	 */
	public function render_output( $form ) {
		$label = $this->get_form_option( $form->id, 'label', _x( 'Are you a human? Solve this:', 'Mathematics task', 'torro-forms-protectors-plus' ) );
		$type  = $this->get_form_option( $form->id, 'type', 'add' );

		$num_1 = rand( 1, 10 );
		$num_2 = rand( 1, 10 );

		$label .= sprintf( " %s %s %s", $num_1, $this->get_operator( $type ), $num_2 );

		?>
       <div id="torro-mathematics-wrap" class="torro-element-wrap">
           <label id="torro-protector-mathematics-label" class="torro-element-label" for="torro-element-1"><?php echo $label; ?></label>
           <div><input id="torro-protector-mathematics-label" name="protector_mathematics[result]" class="torro-element-input"></div>
       </div>
       <input name="protector_mathematics[num_1]" type="hidden" value="<?php echo $num_1; ?>">
       <input name="protector_mathematics[num_2]" type="hidden" value="<?php echo $num_2; ?>">
       <?php
	}

	/**
	 * Get mathematics operator.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type Calculaton type (add, subtract, multiply, divide).
	 *
	 * @return bool|string Operator or false if type not found.
	 */
	public function get_operator( $type ) {
		switch ( $type ) {
			case 'add':
				$operator = __( '+', 'Mathematic operator', 'torro-forms-protectors-plus' );
				break;
			case 'subtract':
				$operator = __( '-', 'Mathematic operator', 'torro-forms-protectors-plus' );
				break;
			case 'multiply':
				$operator = __( '*', 'Mathematic operator', 'torro-forms-protectors-plus' );
				break;
			case 'divide':
				$operator = __( '/', 'Mathematic operator', 'torro-forms-protectors-plus' );
				break;
			default:
				return false;
		}

		return $operator;
	}

	/**
	 * Calculate result.
	 *
	 * @since 1.0.0
	 *
	 * @param int $num_1 Number 1.
	 * @param int $num_2 Number 2.
	 * @param string $type Calculation type (add, subtract, multiply, divide).
	 *
	 * @return bool|float|int Result or false if type not found.
	 */
	public function calculate( $num_1, $num_2, $type ) {
		switch ( $type ) {
			case 'add':
				$result = $num_1 + $num_2;
				break;
			case 'subtract':
				$result = $num_1 - $num_2;
				break;
			case 'multiply':
				$result = $num_1 * $num_2;
				break;
			case 'devide':
				$result = $num_1 / $num_2;
				break;
			default:
				return false;
		}

		return $result;
	}

	/**
	 * Returns the available meta fields for the submodule.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array of `$field_slug => $field_args` pairs.
	 */
	public function get_meta_fields() {
		$meta_fields = parent::get_meta_fields();

		$meta_fields['enabled'] = array(
			'type'         => 'checkbox',
			'label'        => _x( 'Add mathematics task at the end of the form.', 'protector', 'torro-forms-protectors-plus' ),
			'visual_label' => _x( 'Mathematics task', 'protector', 'torro-forms-protectors-plus' ),
		);

		$meta_fields['label'] = array(
			'type'  => 'text',
			'label' => _x( 'Text', 'Mathematics task', 'torro-forms-protectors-plus' ),
			'value' => _x( 'Are you a human? Solve this:', 'Mathematics task', 'torro-forms-protectors-plus' ),
		);

		$meta_fields['type'] = array(
			'type'    => 'select',
			'label'   => _x( 'Type', 'Mathematics task', 'torro-forms-protectors-plus' ),
			'choices' => array(
				'add'      => _x( 'Add (+)', 'Mathematics task type', 'torro-forms-protectors-plus' ),
				'subtract' => _x( 'Subtract (-)', 'Mathematics task type', 'torro-forms-protectors-plus' ),
				'multiply' => _x( 'Multiply (*)', 'Mathematics task type', 'torro-forms-protectors-plus' ),
				'divide'   => _x( 'Divide (/)', 'Mathematics task type', 'torro-forms-protectors-plus' ),
			),
		);

		return $meta_fields;
	}
}
