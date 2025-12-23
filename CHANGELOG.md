# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2025-12-23

### Added

#### New Components (28 new component types)
- **Structure**: `Section`, `Chapter`, `Header`, `Footer`, `Aside`
- **Audio/Media**: `Audio`, `Music`, `Podcast`
- **Tables**: `DataTable`, `HTMLTable`
- **Location**: `Map`, `Place`
- **Text**: `Byline`, `Author`, `Illustrator`, `Photographer`, `Intro`
- **Media**: `Mosaic`, `Figure`, `Logo`, `Portrait`
- **Interactive**: `ARKit`
- **Social**: `TikTok`
- **Advertising**: `BannerAdvertisement`, `MediumRectangleAdvertisement`, `ReplicaAdvertisement`
- **Layout**: `FlexibleSpacer`

#### Behaviors (5 typed behavior classes)
- `BackgroundMotion` - Device motion background effects
- `BackgroundParallax` - Parallax scrolling backgrounds
- `Motion` - Device motion component effects
- `Parallax` - Parallax scrolling effects
- `Springy` - Spring physics scrolling

#### Animations (4 typed animation classes)
- `AppearAnimation` - Component appearance animation
- `FadeInAnimation` - Fade-in effects
- `MoveInAnimation` - Slide-in effects with direction
- `ScaleFadeAnimation` - Combined scale and fade effects

#### Scenes (2 typed scene classes)
- `FadingStickyHeader` - Headers that fade while sticking
- `ParallaxScaleHeader` - Headers with parallax and scale effects

#### Layout & Display
- `ContentDisplayInterface` - Base interface for content displays
- `HorizontalStackDisplay` - Horizontal row layout
- `CollectionDisplay` - Grid layout with alignment options
- `Condition` - Responsive conditions (platform, viewport, color scheme, etc.)
- `AutoPlacement` - Automatic ad placement configuration
- `AdvertisementAutoPlacement` - Ad placement settings

#### Conditional Styles (14 conditional classes for responsive design)
- `ConditionalComponent` - Base conditional component
- `ConditionalContainer` - Container with conditions
- `ConditionalSection` - Section with conditions
- `ConditionalText` - Text with conditions
- `ConditionalDivider` - Divider with conditions
- `ConditionalButton` - Button with conditions
- `ConditionalComponentLayout` - Layout with conditions
- `ConditionalComponentStyle` - Style with conditions
- `ConditionalTextStyle` - Text style with conditions
- `ConditionalComponentTextStyle` - Component text style with conditions
- `ConditionalDocumentStyle` - Document style with conditions
- `ConditionalAutoPlacement` - Auto placement with conditions
- `ConditionalTableRowStyle` - Table row style with conditions
- `ConditionalTableCellStyle` - Table cell style with conditions

#### Style Objects
- **Table Styling**: `TableStyle`, `TableRowStyle`, `TableColumnStyle`, `TableCellStyle`, `TableStrokeStyle`, `TableBorder`, `TableRowSelector`, `TableColumnSelector`
- **Text Styling**: `TextShadow`, `TextShadowOffset`, `TextStrokeStyle`, `ListItemStyle`
- **Component Styling**: `ComponentShadow`, `CornerMask`
- **Fill Types**: `FillInterface`, `ImageFill`, `VideoFill`, `LinearGradientFill`, `RepeatableImageFill`, `ColorStop`

#### Additions & Text
- `AdditionInterface` - Base interface for additions
- `LinkAddition` - Make text ranges tappable
- `ComponentLink` - Make entire components tappable
- `CalendarEventAddition` - Create calendar events from text
- `FormattedText` - Rich text with styling support
- `CaptionDescriptor` - Rich captions for media components
- `InlineTextStyle` - Style specific text ranges

#### API Enhancements
- `ArticleMetadata` builder with `isSponsored`, `maturityRating`, `targetTerritoryCountryCodes`, `isCandidateToBeFeatured`
- `ArticleResponse`, `SearchResponse`, `SectionResponse` DTOs
- `Throttling` object for rate limit handling
- `Issue` object for magazine/periodical support
- `contentGenerationType` for AI disclosure

### Changed
- Improved test coverage to 99.92%
- Enhanced `Container` component with `setContentDisplayObject()` method
- All conditional classes implement `ConditionalInterface`

## [1.0.8] - 2025-12-23

### Fixed
- Internal links in Markdown documentation for GitHub

## [1.0.7] - 2025-12-23

### Added
- New Markdown documentation for GitHub

## [1.0.6] - 2025-12-23

### Changed
- Updated changelog and README

### Fixed
- Test fixes

## [1.0.5] - 2025-12-23

### Added
- Additional test coverage

## [1.0.4] - 2025-12-20

### Changed
- Updated minimum requirements for PSR packages

## [1.0.3] - 2025-12-20

### Changed
- Restructured Markdown documentation

### Added
- Documentation in Markdown format

## [1.0.2] - 2025-12-20

### Added
- Link to documentation in README

## [1.0.1] - 2025-12-20

### Fixed
- Missing PHPStan declarations

## [1.0.0] - 2025-12-20

### Added
- Initial release
- Full Apple News Format (ANF) document builder
- PSR-18 compatible HTTP client
- HMAC-SHA256 authentication
- Channel, Section, and Article API operations
- Support for all ANF components (Title, Body, Photo, Video, Gallery, etc.)
- Multipart request builder for bundled assets
- Comprehensive test suite (99%+ coverage)
- PHPDoc documentation
- README documentation
- Fixed Apple documentation links
