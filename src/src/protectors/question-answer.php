<?php
/**
 * Question & Answer protector class
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
 * Class for a protector using easy queston & asnwer.
 *
 * @since 1.0.0
 */
class Question_Answer extends Protector { // @codingStandardsIgnoreLine

	/**
	 * Bootstraps the submodule by setting properties.
	 *
	 * @since 1.0.0
	 */
	protected function bootstrap() {
		$this->slug  = 'question-answer';
		$this->title = __( 'Question & Answer', 'torro-forms-protectors-plus' );
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
		$entered = $_POST['protector_question_answer'];

		if ( empty( $entered ) ) { // phpcs:ignore WordPress.Security
			return new WP_Error( 'protector_mathematics_missing_input', __( 'Missing answer to last question. Please check the question to verify you are human.', 'torro-forms-protectors-plus' ) );
		}

		$expected = $this->get_form_option( $form->id, 'answer' );

		if ( $expected !== $entered ) {
			return new WP_Error( 'protector_question_answer_wrong_entered', __( 'Answer on last question is wrong. Please check the question to verify you are human.', 'torro-forms-protectors-plus' ) );
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
		$question = $this->get_form_option( $form->id, 'question' );

		?>
       <div id="torro-mathematics-wrap" class="torro-element-wrap">
           <label id="torro-protector-question-answer-label" class="torro-element-label" for="torro-protector-question-answer-label"><?php echo $question; ?></label>
           <div><input id="torro-protector-question-answer-label" name="protector_question_answer" class="torro-element-input"></div>
       </div>
		<?php
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
			'label'        => _x( 'Add question at the end of the form which have to be answered like the given answer.', 'protector', 'torro-forms-protectors-plus' ),
			'visual_label' => _x( 'Question & Answer', 'protector', 'torro-forms-protectors-plus' ),
		);

		$meta_fields['question'] = array(
			'type'        => 'text',
			'label'       => _x( 'Question to ask', 'Question & Answer', 'torro-forms-protectors-plus' ),
			'placeholder' => _x( 'Which color has an elephant?', 'Question & Answer', 'torro-forms-protectors-plus' ),
		);

		$meta_fields['answer'] = array(
			'type'        => 'text',
			'label'       => _x( 'Answer', 'Question & Answer', 'torro-forms-protectors-plus' ),
			'placeholder' => _x( 'grey', 'Question & Answer', 'torro-forms-protectors-plus' ),
		);

		return $meta_fields;
	}
}
