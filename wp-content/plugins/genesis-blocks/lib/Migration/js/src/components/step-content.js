// @ts-check

/**
 * External dependencies
 */
import * as React from 'react';

/**
 * @typedef StepContentProps
 * @property {React.ReactNode} children     The component's children.
 * @property {string}          heading      The step heading.
 * @property {boolean}         isStepActive Whether this step is active.
 * @property {boolean}         isLastStep   Is this the last step?
 */

/**
 * The content of the step.
 *
 * @param {StepContentProps} props The component props.
 * @return {React.ReactElement} The component for the step content.
 */
const StepContent = ({ children, heading, isStepActive, isLastStep }) => {
	return (
		<div className="step-content">
			<h3>{heading}</h3>
			{(isStepActive || isLastStep) && children}
		</div>
	);
};

export default StepContent;
