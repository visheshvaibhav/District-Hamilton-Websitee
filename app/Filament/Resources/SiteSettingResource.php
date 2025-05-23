<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?string $navigationLabel = 'Site Settings';
    
    protected static ?int $navigationSort = 3;
    
    protected static ?string $recordTitleAttribute = 'restaurant_name';
    
    protected static bool $shouldRegisterNavigation = true;
    
    protected static ?string $slug = 'site-settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Restaurant Information')
                            ->schema([
                                Forms\Components\TextInput::make('restaurant_name')
                                    ->label('Restaurant Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->default('The District Tapas + Bar'),
                                    
                                Forms\Components\TextInput::make('restaurant_email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                    
                                Forms\Components\TextInput::make('restaurant_phone')
                                    ->label('Contact Phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                    
                                Forms\Components\Textarea::make('restaurant_address')
                                    ->label('Address')
                                    ->rows(3)
                                    ->maxLength(1000),
                            ])->columns(2),
                            
                        Forms\Components\Tabs\Tab::make('Website Images')
                            ->schema([
                                Forms\Components\FileUpload::make('logo_path')
                                    ->label('Logo')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1')
                                    ->directory('site/logo')
                                    ->columnSpanFull()
                                    ->helperText('Square logo image for the website header. Recommended size: 200x200px')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->openable(),
                                    
                                Forms\Components\FileUpload::make('hero_image_path')
                                    ->label('Hero Image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->directory('site/hero')
                                    ->helperText('Large banner image for homepage. Recommended size: 1920x1080px')
                                    ->columnSpanFull()
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->openable(),
                                    
                                Forms\Components\FileUpload::make('about_image_path')
                                    ->label('About Us Image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->directory('site/about')
                                    ->helperText('Image for the About Us section. Recommended size: 800x600px')
                                    ->columnSpanFull()
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->openable(),
                                    
                                Forms\Components\FileUpload::make('story_image_path')
                                    ->label('Our Story Image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->directory('site/story')
                                    ->helperText('Image for the Our Story section. Recommended size: 800x600px')
                                    ->columnSpanFull()
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->openable(),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Features')
                            ->schema([
                                Forms\Components\Toggle::make('gift_card_system_enabled')
                                    ->label('Enable Gift Card System')
                                    ->helperText('Turn off to hide all gift card functionality from the site')
                                    ->default(false)
                                    ->disabled(),
                                    
                                Forms\Components\Textarea::make('alert_message')
                                    ->label('Site Alert/Announcement')
                                    ->placeholder('Leave empty for no alert')
                                    ->helperText('This message will appear at the top of all pages (e.g., for holiday hours)')
                                    ->maxLength(500),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Language Settings')
                            ->schema([
                                Forms\Components\Select::make('primary_language')
                                    ->label('Primary Language')
                                    ->options([
                                        'en' => 'English',
                                        'fr' => 'French',
                                    ])
                                    ->default('en')
                                    ->required(),
                                    
                                Forms\Components\Toggle::make('enable_french')
                                    ->label('Enable French Language Support')
                                    ->helperText('When enabled, users can toggle between English and French on the site')
                                    ->default(false),
                            ]),
                    ])->columnSpanFull(),
                Section::make('API Configuration')
                    ->schema([
                        TextInput::make('mailgun_api_key')
                            ->label('Mailgun API Key')
                            ->placeholder('Enter your Mailgun API key')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),
                            
                        TextInput::make('stripe_api_key')
                            ->label('Stripe API Key')
                            ->placeholder('Enter your Stripe API key')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null),
                            
                        TextInput::make('admin_email')
                            ->label('Admin Email Address')
                            ->placeholder('Enter the admin email address')
                            ->email()
                            ->required(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('restaurant_name')
                    ->label('Name')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('restaurant_email')
                    ->label('Email')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('restaurant_phone')
                    ->label('Phone')
                    ->searchable(),
                    
                Tables\Columns\IconColumn::make('gift_card_system_enabled')
                    ->label('Gift Cards')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('primary_language')
                    ->label('Language')
                    ->formatStateUsing(fn ($state) => $state === 'en' ? 'English' : 'French'),
                    
                Tables\Columns\IconColumn::make('enable_french')
                    ->label('French Support')
                    ->boolean(),
                    
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->circular(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // No bulk actions needed for a singleton
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSiteSettings::route('/'),
        ];
    }
} 