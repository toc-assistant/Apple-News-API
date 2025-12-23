
This is an automatically generated documentation for **Apple News API PHP Client**.

## Namespaces

### \TomGould\AppleNews\Client

#### Classes

| Class                                                                    | Description                                                     |
|--------------------------------------------------------------------------|-----------------------------------------------------------------|
| [`AppleNewsClient`](./classes/TomGould/AppleNews/Client/AppleNewsClient) | Apple News Publisher API Client.                                |
| [`Authenticator`](./classes/TomGould/AppleNews/Client/Authenticator)     | Handles HMAC-SHA256 authentication for Apple News API requests. |

### \TomGould\AppleNews\Document

#### Classes

| Class                                                        | Description                                             |
|--------------------------------------------------------------|---------------------------------------------------------|
| [`Article`](./classes/TomGould/AppleNews/Document/Article)   | Represents an Apple News Format (ANF) article document. |
| [`Issue`](./classes/TomGould/AppleNews/Document/Issue)       | Issue information for magazine and periodical content.  |
| [`Metadata`](./classes/TomGould/AppleNews/Document/Metadata) | Article metadata for Apple News Format.                 |

### \TomGould\AppleNews\Document\Additions

#### Classes

| Class                                                                                            | Description                                           |
|--------------------------------------------------------------------------------------------------|-------------------------------------------------------|
| [`CalendarEventAddition`](./classes/TomGould/AppleNews/Document/Additions/CalendarEventAddition) | Calendar event addition for creating calendar events. |
| [`ComponentLink`](./classes/TomGould/AppleNews/Document/Additions/ComponentLink)                 | Component link for making entire components tappable. |
| [`LinkAddition`](./classes/TomGould/AppleNews/Document/Additions/LinkAddition)                   | Link addition for making text ranges tappable.        |

#### Interfaces

| Interface                                                                                | Description                       |
|------------------------------------------------------------------------------------------|-----------------------------------|
| [`AdditionInterface`](./classes/TomGould/AppleNews/Document/Additions/AdditionInterface) | Interface for all addition types. |

### \TomGould\AppleNews\Document\Animations

#### Classes

| Class                                                                                       | Description                          |
|---------------------------------------------------------------------------------------------|--------------------------------------|
| [`AppearAnimation`](./classes/TomGould/AppleNews/Document/Animations/AppearAnimation)       | Appear animation for components.     |
| [`FadeInAnimation`](./classes/TomGould/AppleNews/Document/Animations/FadeInAnimation)       | Fade-in animation for components.    |
| [`MoveInAnimation`](./classes/TomGould/AppleNews/Document/Animations/MoveInAnimation)       | Move-in animation for components.    |
| [`ScaleFadeAnimation`](./classes/TomGould/AppleNews/Document/Animations/ScaleFadeAnimation) | Scale-fade animation for components. |

#### Interfaces

| Interface                                                                                   | Description                                 |
|---------------------------------------------------------------------------------------------|---------------------------------------------|
| [`AnimationInterface`](./classes/TomGould/AppleNews/Document/Animations/AnimationInterface) | Interface for all ANF component animations. |

### \TomGould\AppleNews\Document\Behaviors

#### Classes

| Class                                                                                      | Description                                                       |
|--------------------------------------------------------------------------------------------|-------------------------------------------------------------------|
| [`BackgroundMotion`](./classes/TomGould/AppleNews/Document/Behaviors/BackgroundMotion)     | BackgroundMotion behavior for background motion effects.          |
| [`BackgroundParallax`](./classes/TomGould/AppleNews/Document/Behaviors/BackgroundParallax) | BackgroundParallax behavior for scroll-based background parallax. |
| [`Motion`](./classes/TomGould/AppleNews/Document/Behaviors/Motion)                         | Motion behavior for device motion-based parallax.                 |
| [`Parallax`](./classes/TomGould/AppleNews/Document/Behaviors/Parallax)                     | Parallax behavior for scroll-based parallax effects.              |
| [`Springy`](./classes/TomGould/AppleNews/Document/Behaviors/Springy)                       | Springy behavior for device tilt-based movement.                  |

#### Interfaces

| Interface                                                                                | Description                                |
|------------------------------------------------------------------------------------------|--------------------------------------------|
| [`BehaviorInterface`](./classes/TomGould/AppleNews/Document/Behaviors/BehaviorInterface) | Interface for all ANF component behaviors. |

### \TomGould\AppleNews\Document\Components

#### Classes

| Class                                                                                                           | Description                                                               |
|-----------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------|
| [`ARKit`](./classes/TomGould/AppleNews/Document/Components/ARKit)                                               | ARKit component for augmented reality experiences.                        |
| [`ArticleLink`](./classes/TomGould/AppleNews/Document/Components/ArticleLink)                                   | Article link component.                                                   |
| [`Aside`](./classes/TomGould/AppleNews/Document/Components/Aside)                                               | Aside container component.                                                |
| [`Audio`](./classes/TomGould/AppleNews/Document/Components/Audio)                                               | Audio component for audio content playback.                               |
| [`Author`](./classes/TomGould/AppleNews/Document/Components/Author)                                             | Author name component.                                                    |
| [`BannerAdvertisement`](./classes/TomGould/AppleNews/Document/Components/BannerAdvertisement)                   | Banner advertisement component.                                           |
| [`Body`](./classes/TomGould/AppleNews/Document/Components/Body)                                                 | The standard text component for body paragraphs.                          |
| [`Byline`](./classes/TomGould/AppleNews/Document/Components/Byline)                                             | Byline component for publication date and contributor credits.            |
| [`Caption`](./classes/TomGould/AppleNews/Document/Components/Caption)                                           | A standard text component for captions.                                   |
| [`Chapter`](./classes/TomGould/AppleNews/Document/Components/Chapter)                                           | Chapter container component.                                              |
| [`Component`](./classes/TomGould/AppleNews/Document/Components/Component)                                       | Base class for all Apple News Format (ANF) components.                    |
| [`Container`](./classes/TomGould/AppleNews/Document/Components/Container)                                       | A container component used to group other components together.            |
| [`DataTable`](./classes/TomGould/AppleNews/Document/Components/DataTable)                                       | DataTable component for structured tabular data.                          |
| [`Divider`](./classes/TomGould/AppleNews/Document/Components/Divider)                                           | A visual separator line used between other components.                    |
| [`EmbedWebVideo`](./classes/TomGould/AppleNews/Document/Components/EmbedWebVideo)                               | Embeds third-party video content (YouTube, Vimeo, etc.).                  |
| [`FacebookPost`](./classes/TomGould/AppleNews/Document/Components/FacebookPost)                                 | Component for embedding Facebook posts.                                   |
| [`Figure`](./classes/TomGould/AppleNews/Document/Components/Figure)                                             | Figure component for images with semantic meaning.                        |
| [`FlexibleSpacer`](./classes/TomGould/AppleNews/Document/Components/FlexibleSpacer)                             | Flexible spacer component for dynamic spacing in horizontal stacks.       |
| [`Gallery`](./classes/TomGould/AppleNews/Document/Components/Gallery)                                           | Component for displaying a collection of images as a gallery.             |
| [`Header`](./classes/TomGould/AppleNews/Document/Components/Header)                                             | Header container component.                                               |
| [`Heading`](./classes/TomGould/AppleNews/Document/Components/Heading)                                           | A heading component (supports levels 1 through 6).                        |
| [`HTMLTable`](./classes/TomGould/AppleNews/Document/Components/HTMLTable)                                       | HTMLTable component for HTML-formatted tables.                            |
| [`Illustrator`](./classes/TomGould/AppleNews/Document/Components/Illustrator)                                   | Illustrator credit component.                                             |
| [`Image`](./classes/TomGould/AppleNews/Document/Components/Image)                                               | Generic image component.                                                  |
| [`Instagram`](./classes/TomGould/AppleNews/Document/Components/Instagram)                                       | Component for embedding Instagram posts.                                  |
| [`Intro`](./classes/TomGould/AppleNews/Document/Components/Intro)                                               | Introductory or deck text component.                                      |
| [`LinkButton`](./classes/TomGould/AppleNews/Document/Components/LinkButton)                                     | A call-to-action button that links to an external URL or article section. |
| [`Logo`](./classes/TomGould/AppleNews/Document/Components/Logo)                                                 | Logo component for brand or publication logos.                            |
| [`Map`](./classes/TomGould/AppleNews/Document/Components/Map)                                                   | Map component for displaying Apple Maps.                                  |
| [`MediumRectangleAdvertisement`](./classes/TomGould/AppleNews/Document/Components/MediumRectangleAdvertisement) | Medium rectangle advertisement component (MREC).                          |
| [`Mosaic`](./classes/TomGould/AppleNews/Document/Components/Mosaic)                                             | Mosaic component for multi-image tile layouts.                            |
| [`Music`](./classes/TomGould/AppleNews/Document/Components/Music)                                               | Music component for Apple Music integration.                              |
| [`Photo`](./classes/TomGould/AppleNews/Document/Components/Photo)                                               | Component for displaying single images in an article.                     |
| [`Photographer`](./classes/TomGould/AppleNews/Document/Components/Photographer)                                 | Photographer credit component.                                            |
| [`Place`](./classes/TomGould/AppleNews/Document/Components/Place)                                               | Place component for displaying a specific location.                       |
| [`Podcast`](./classes/TomGould/AppleNews/Document/Components/Podcast)                                           | Podcast component for Apple Podcasts integration.                         |
| [`Portrait`](./classes/TomGould/AppleNews/Document/Components/Portrait)                                         | Portrait component for face-optimized image cropping.                     |
| [`Pullquote`](./classes/TomGould/AppleNews/Document/Components/Pullquote)                                       | Component for highlighting a quote within an article.                     |
| [`Quote`](./classes/TomGould/AppleNews/Document/Components/Quote)                                               | Block quote component.                                                    |
| [`ReplicaAdvertisement`](./classes/TomGould/AppleNews/Document/Components/ReplicaAdvertisement)                 | Replica advertisement component.                                          |
| [`Section`](./classes/TomGould/AppleNews/Document/Components/Section)                                           | Section container component.                                              |
| [`TextComponent`](./classes/TomGould/AppleNews/Document/Components/TextComponent)                               | Base class for all components that primarily contain text content.        |
| [`TikTok`](./classes/TomGould/AppleNews/Document/Components/TikTok)                                             | TikTok component for embedding TikTok videos.                             |
| [`Title`](./classes/TomGould/AppleNews/Document/Components/Title)                                               | The main title component for an article.                                  |
| [`Tweet`](./classes/TomGould/AppleNews/Document/Components/Tweet)                                               | Component for embedding X/Twitter posts.                                  |
| [`Video`](./classes/TomGould/AppleNews/Document/Components/Video)                                               | Component for displaying native hosted videos.                            |

### \TomGould\AppleNews\Document\Conditionals

#### Classes

| Class                                                                                                               | Description                                      |
|---------------------------------------------------------------------------------------------------------------------|--------------------------------------------------|
| [`ConditionalAutoPlacement`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalAutoPlacement)           | Conditional auto-placement configuration.        |
| [`ConditionalButton`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalButton)                         | Conditional properties for button components.    |
| [`ConditionalComponent`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalComponent)                   | Conditional properties for any component.        |
| [`ConditionalComponentLayout`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalComponentLayout)       | Conditional properties for component layouts.    |
| [`ConditionalComponentStyle`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalComponentStyle)         | Conditional properties for component styles.     |
| [`ConditionalComponentTextStyle`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalComponentTextStyle) | Conditional text style for component text.       |
| [`ConditionalContainer`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalContainer)                   | Conditional properties for container components. |
| [`ConditionalDivider`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalDivider)                       | Conditional properties for divider components.   |
| [`ConditionalDocumentStyle`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalDocumentStyle)           | Conditional properties for document styles.      |
| [`ConditionalSection`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalSection)                       | Conditional properties for section components.   |
| [`ConditionalTableCellStyle`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalTableCellStyle)         | Conditional properties for table cell styles.    |
| [`ConditionalTableRowStyle`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalTableRowStyle)           | Conditional properties for table row styles.     |
| [`ConditionalText`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalText)                             | Conditional properties for text components.      |
| [`ConditionalTextStyle`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalTextStyle)                   | Conditional properties for text styles.          |

#### Interfaces

| Interface                                                                                         | Description                            |
|---------------------------------------------------------------------------------------------------|----------------------------------------|
| [`ConditionalInterface`](./classes/TomGould/AppleNews/Document/Conditionals/ConditionalInterface) | Interface for all conditional objects. |

### \TomGould\AppleNews\Document\Layouts

#### Classes

| Class                                                                                                    | Description                                                     |
|----------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------|
| [`AdvertisementAutoPlacement`](./classes/TomGould/AppleNews/Document/Layouts/AdvertisementAutoPlacement) | Advertisement auto-placement configuration.                     |
| [`AutoPlacement`](./classes/TomGould/AppleNews/Document/Layouts/AutoPlacement)                           | Auto-placement configuration for automatic component insertion. |
| [`CollectionDisplay`](./classes/TomGould/AppleNews/Document/Layouts/CollectionDisplay)                   | Collection display for grid-like component arrangements.        |
| [`Condition`](./classes/TomGould/AppleNews/Document/Layouts/Condition)                                   | Condition object for conditional component properties.          |
| [`HorizontalStackDisplay`](./classes/TomGould/AppleNews/Document/Layouts/HorizontalStackDisplay)         | Horizontal stack display for arranging components horizontally. |
| [`Layout`](./classes/TomGould/AppleNews/Document/Layouts/Layout)                                         | Defines the column system and base grid for an article.         |

#### Interfaces

| Interface                                                                                          | Description                                  |
|----------------------------------------------------------------------------------------------------|----------------------------------------------|
| [`ContentDisplayInterface`](./classes/TomGould/AppleNews/Document/Layouts/ContentDisplayInterface) | Interface for all ANF content display types. |

### \TomGould\AppleNews\Document\Scenes

#### Classes

| Class                                                                                     | Description                  |
|-------------------------------------------------------------------------------------------|------------------------------|
| [`FadingStickyHeader`](./classes/TomGould/AppleNews/Document/Scenes/FadingStickyHeader)   | Fading sticky header scene.  |
| [`ParallaxScaleHeader`](./classes/TomGould/AppleNews/Document/Scenes/ParallaxScaleHeader) | Parallax scale header scene. |

#### Interfaces

| Interface                                                                       | Description                        |
|---------------------------------------------------------------------------------|------------------------------------|
| [`SceneInterface`](./classes/TomGould/AppleNews/Document/Scenes/SceneInterface) | Interface for all ANF scene types. |

### \TomGould\AppleNews\Document\Styles

#### Classes

| Class                                                                                     | Description                                           |
|-------------------------------------------------------------------------------------------|-------------------------------------------------------|
| [`ComponentShadow`](./classes/TomGould/AppleNews/Document/Styles/ComponentShadow)         | Shadow effect for components.                         |
| [`ComponentTextStyle`](./classes/TomGould/AppleNews/Document/Styles/ComponentTextStyle)   | Detailed text styling options for components.         |
| [`CornerMask`](./classes/TomGould/AppleNews/Document/Styles/CornerMask)                   | Rounded corner clipping for components.               |
| [`DocumentStyle`](./classes/TomGould/AppleNews/Document/Styles/DocumentStyle)             | Global styles applied to the entire article document. |
| [`ListItemStyle`](./classes/TomGould/AppleNews/Document/Styles/ListItemStyle)             | Style for bullet or numbered list items.              |
| [`TableBorder`](./classes/TomGould/AppleNews/Document/Styles/TableBorder)                 | Border configuration for tables.                      |
| [`TableCellStyle`](./classes/TomGould/AppleNews/Document/Styles/TableCellStyle)           | Style for table cells.                                |
| [`TableColumnSelector`](./classes/TomGould/AppleNews/Document/Styles/TableColumnSelector) | Selector for targeting specific table columns.        |
| [`TableColumnStyle`](./classes/TomGould/AppleNews/Document/Styles/TableColumnStyle)       | Style for table columns.                              |
| [`TableRowSelector`](./classes/TomGould/AppleNews/Document/Styles/TableRowSelector)       | Selector for targeting specific table rows.           |
| [`TableRowStyle`](./classes/TomGould/AppleNews/Document/Styles/TableRowStyle)             | Style for table rows.                                 |
| [`TableStrokeStyle`](./classes/TomGould/AppleNews/Document/Styles/TableStrokeStyle)       | Stroke style for table borders and dividers.          |
| [`TableStyle`](./classes/TomGould/AppleNews/Document/Styles/TableStyle)                   | Overall table style configuration.                    |
| [`TextShadow`](./classes/TomGould/AppleNews/Document/Styles/TextShadow)                   | Shadow effect for text.                               |
| [`TextShadowOffset`](./classes/TomGould/AppleNews/Document/Styles/TextShadowOffset)       | Offset positioning for text shadows.                  |
| [`TextStrokeStyle`](./classes/TomGould/AppleNews/Document/Styles/TextStrokeStyle)         | Text outline/stroke styling.                          |

### \TomGould\AppleNews\Document\Styles\Fills

#### Classes

| Class                                                                                           | Description                             |
|-------------------------------------------------------------------------------------------------|-----------------------------------------|
| [`ColorStop`](./classes/TomGould/AppleNews/Document/Styles/Fills/ColorStop)                     | Color stop for gradient fills.          |
| [`ImageFill`](./classes/TomGould/AppleNews/Document/Styles/Fills/ImageFill)                     | Image background fill.                  |
| [`LinearGradientFill`](./classes/TomGould/AppleNews/Document/Styles/Fills/LinearGradientFill)   | Linear gradient background fill.        |
| [`RepeatableImageFill`](./classes/TomGould/AppleNews/Document/Styles/Fills/RepeatableImageFill) | Tiled/repeatable image background fill. |
| [`VideoFill`](./classes/TomGould/AppleNews/Document/Styles/Fills/VideoFill)                     | Video background fill.                  |

#### Interfaces

| Interface                                                                           | Description                   |
|-------------------------------------------------------------------------------------|-------------------------------|
| [`FillInterface`](./classes/TomGould/AppleNews/Document/Styles/Fills/FillInterface) | Interface for all fill types. |

### \TomGould\AppleNews\Document\Text

#### Classes

| Class                                                                               | Description                                        |
|-------------------------------------------------------------------------------------|----------------------------------------------------|
| [`CaptionDescriptor`](./classes/TomGould/AppleNews/Document/Text/CaptionDescriptor) | Caption descriptor for media components.           |
| [`FormattedText`](./classes/TomGould/AppleNews/Document/Text/FormattedText)         | Formatted text with styling support.               |
| [`InlineTextStyle`](./classes/TomGould/AppleNews/Document/Text/InlineTextStyle)     | Inline text style for specific ranges within text. |

### \TomGould\AppleNews\Exception

#### Classes

| Class                                                                                       | Description                                                                   |
|---------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------|
| [`AppleNewsException`](./classes/TomGould/AppleNews/Exception/AppleNewsException)           | Base exception class for all errors returned by the Apple News API.           |
| [`AuthenticationException`](./classes/TomGould/AppleNews/Exception/AuthenticationException) | Exception thrown specifically when API authentication fails (401/403 errors). |

### \TomGould\AppleNews\Request

#### Classes

| Class                                                                       | Description                                                                  |
|-----------------------------------------------------------------------------|------------------------------------------------------------------------------|
| [`ArticleMetadata`](./classes/TomGould/AppleNews/Request/ArticleMetadata)   | Builder for API-level metadata sent with Create and Update Article requests. |
| [`MultipartBuilder`](./classes/TomGould/AppleNews/Request/MultipartBuilder) | Builds multipart/form-data request bodies for the Apple News API.            |

### \TomGould\AppleNews\Response

#### Classes

| Class                                                                      | Description                                                                       |
|----------------------------------------------------------------------------|-----------------------------------------------------------------------------------|
| [`ArticleLinks`](./classes/TomGould/AppleNews/Response/ArticleLinks)       | Links associated with an article response.                                        |
| [`ArticleResponse`](./classes/TomGould/AppleNews/Response/ArticleResponse) | Complete response from Create, Read, and Update Article endpoints.                |
| [`Meta`](./classes/TomGould/AppleNews/Response/Meta)                       | Meta object wrapping throttling information from Create/Update Article responses. |
| [`Throttling`](./classes/TomGould/AppleNews/Response/Throttling)           | Throttling information returned by Create and Update Article endpoints.           |
| [`Warning`](./classes/TomGould/AppleNews/Response/Warning)                 | Warning message returned by the Apple News API for non-fatal issues.              |
