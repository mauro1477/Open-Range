/**
 * Inspector Controls
 * Font size, color, background color
 * This is used for multiple pricing table components using the same inspector settings
 */

// Import Inspector settings
import Padding from './../../../../utils/components/padding';

// Import block dependencies and components
const { __ } = wp.i18n;
const { Component } = wp.element;
const { compose } = wp.compose;

const {
	InspectorControls,
	FontSizePicker,
	withFontSizes,
	withColors,
	ContrastChecker,
	PanelColorSettings,
} = wp.blockEditor;

const {
	withFallbackStyles,
	PanelBody,
	ToggleControl,
	TextControl,
	RangeControl,
} = wp.components;

// Apply fallback styles
const applyFallbackStyles = withFallbackStyles((node, ownProps) => {
	const { textColor, backgroundColor, fontSize, customFontSize } =
		ownProps.attributes;
	const editableNode = node.querySelector('[contenteditable="true"]');
	const computedStyles = editableNode ? getComputedStyle(editableNode) : null;
	return {
		fallbackBackgroundColor:
			backgroundColor || !computedStyles
				? undefined
				: computedStyles.backgroundColor,
		fallbackTextColor:
			textColor || !computedStyles ? undefined : computedStyles.color,
		fallbackFontSize:
			fontSize || customFontSize || !computedStyles
				? undefined
				: parseInt(computedStyles.fontSize) || undefined,
	};
});

/**
 * Create an Inspector Controls wrapper Component
 */
class Inspector extends Component {
	render() {
		// Setup the attributes
		const {
			attributes: {
				showTerm,
				showCurrency,
				term,
				currency,
				paddingTop,
				paddingRight,
				paddingBottom,
				paddingLeft,
			},
			isSelected,
			setAttributes,
			fallbackFontSize,
			fontSize,
			setFontSize,
			backgroundColor,
			textColor,
			setBackgroundColor,
			setTextColor,
			fallbackBackgroundColor,
			fallbackTextColor,
		} = this.props;

		return (
			<InspectorControls key="inspector">
				<PanelBody title={__('Text Settings', 'genesis-blocks')}>
					<FontSizePicker
						fallbackFontSize={fallbackFontSize}
						value={fontSize.size}
						onChange={setFontSize}
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={__('Show currency symbol', 'genesis-blocks')}
						checked={showCurrency}
						onChange={() =>
							this.props.setAttributes({
								showCurrency: !showCurrency,
							})
						}
					/>
					{showCurrency && (
						<TextControl
							label={__('Currency Symbol', 'genesis-blocks')}
							type="text"
							value={currency}
							onChange={(value) =>
								this.props.setAttributes({ currency: value })
							}
						/>
					)}
					<ToggleControl
						label={__('Show pricing duration', 'genesis-blocks')}
						checked={showTerm}
						onChange={() =>
							this.props.setAttributes({ showTerm: !showTerm })
						}
					/>
					{showTerm && (
						<TextControl
							label={__('Pricing Duration', 'genesis-blocks')}
							type="text"
							value={term}
							onChange={(value) =>
								this.props.setAttributes({ term: value })
							}
						/>
					)}
				</PanelBody>
				<PanelBody
					title={__('Padding Settings', 'genesis-blocks')}
					initialOpen={false}
				>
					<Padding
						// Top padding
						paddingEnableTop={true}
						paddingTop={paddingTop}
						paddingTopMin="0"
						paddingTopMax="100"
						onChangePaddingTop={(paddingTop) =>
							setAttributes({ paddingTop })
						}
						// Right padding
						paddingEnableRight={true}
						paddingRight={paddingRight}
						paddingRightMin="0"
						paddingRightMax="100"
						onChangePaddingRight={(paddingRight) =>
							setAttributes({ paddingRight })
						}
						// Bottom padding
						paddingEnableBottom={true}
						paddingBottom={paddingBottom}
						paddingBottomMin="0"
						paddingBottomMax="100"
						onChangePaddingBottom={(paddingBottom) =>
							setAttributes({ paddingBottom })
						}
						// Left padding
						paddingEnableLeft={true}
						paddingLeft={paddingLeft}
						paddingLeftMin="0"
						paddingLeftMax="100"
						onChangePaddingLeft={(paddingLeft) =>
							setAttributes({ paddingLeft })
						}
					/>
				</PanelBody>
				<PanelColorSettings
					title={__('Color Settings', 'genesis-blocks')}
					initialOpen={false}
					colorSettings={[
						{
							value: backgroundColor.color,
							onChange: setBackgroundColor,
							label: __('Background Color', 'genesis-blocks'),
						},
						{
							value: textColor.color,
							onChange: setTextColor,
							label: __('Text Color', 'genesis-blocks'),
						},
					]}
				>
					<ContrastChecker
						{...{
							textColor: textColor.color,
							backgroundColor: backgroundColor.color,
							fallbackTextColor,
							fallbackBackgroundColor,
						}}
						fontSize={fontSize.size}
					/>
				</PanelColorSettings>
			</InspectorControls>
		);
	}
}

export default compose([
	applyFallbackStyles,
	withFontSizes('fontSize'),
	withColors('backgroundColor', { textColor: 'color' }),
])(Inspector);
