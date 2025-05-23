/**
 * Internal dependencies
 */
import classnames from 'classnames';
import ProfileBox from './profile';
import SocialIcons from './social';
import AvatarColumn from './avatar';

/**
 * WordPress dependencies
 */
const { Component } = wp.element;
const { RichText } = wp.blockEditor;

export default class Save extends Component {
	render() {
		const {
			profileName,
			profileTitle,
			profileContent,
			profileImgURL,
			profileImgAlt,
			profileImgID,
			profileTextColor,
		} = this.props.attributes;

		return (
			/* Save the block markup for the front end */
			<ProfileBox {...this.props}>
				{profileImgURL && profileImgID && (
					<AvatarColumn {...this.props}>
						<figure className="gb-profile-image-square">
							<img
								className={classnames(
									'gb-profile-avatar',
									'wp-image-' + profileImgID
								)}
								src={profileImgURL}
								alt={profileImgAlt}
							/>
						</figure>
					</AvatarColumn>
				)}

				<div
					className={classnames(
						'gb-profile-column gb-profile-content-wrap'
					)}
				>
					<RichText.Content
						tagName="h2"
						className="gb-profile-name"
						style={{
							color: profileTextColor,
						}}
						value={profileName}
					/>

					<RichText.Content
						tagName="p"
						className="gb-profile-title"
						style={{
							color: profileTextColor,
						}}
						value={profileTitle}
					/>

					<RichText.Content
						tagName="div"
						className="gb-profile-text"
						value={profileContent}
					/>

					<SocialIcons {...this.props} />
				</div>
			</ProfileBox>
		);
	}
}
