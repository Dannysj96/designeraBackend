<?php

namespace App\Filament\Pages;

use App\Helpers\FileManagerAction;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea; // Added Textarea import
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static \UnitEnum|string|null $navigationGroup = null;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 20;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::currentArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('Settings Tabs')
                    ->tabs([
                        Tab::make('Site')
                            ->schema([
                                Section::make('General Site Settings')
                                    ->description('Manage website branding, site title, and system contact email')
                                    ->components([
                                        FileUpload::make('logo')
                                            ->label('Site Logo')
                                            ->image()
                                            ->disk('public')
                                            ->directory('site-settings')
                                            ->maxSize(2048)
                                            ->hintAction(FileManagerAction::make())
                                            ->helperText('Upload a logo image (PNG, JPG, SVG, WebP) - Max 2MB')
                                            ->columnSpanFull(),

                                        Grid::make(2)->components([
                                            TextInput::make('site_title')
                                                ->label('Site Title')
                                                ->required()
                                                ->placeholder('e.g. Designera')
                                                ->maxLength(255),

                                            TextInput::make('site_subtitle')
                                                ->label('Site Subtitle / Tagline')
                                                ->placeholder('e.g. Nextjs + shadcn/ui')
                                                ->maxLength(255),

                                            TextInput::make('email')
                                                ->label('System / Admin Email')
                                                ->email()
                                                ->required()
                                                ->placeholder('e.g. admin@designera.com')
                                                ->maxLength(255)
                                                ->columnSpanFull(),
                                        ]),
                                    ]),

                                Section::make('Contact Information')
                                    ->components([
                                        Grid::make(2)->components([
                                            TextInput::make('phone')
                                                ->label('Phone')
                                                ->tel()
                                                ->maxLength(255),

                                            TextInput::make('whatsapp_number')
                                                ->label('Home Screen WhatsApp Number')
                                                ->tel()
                                                ->placeholder('e.g. 919158592601')
                                                ->helperText('WhatsApp number with country code (e.g. 919158592601)')
                                                ->maxLength(50),

                                            Textarea::make('address')
                                                ->label('Address')
                                                ->rows(2)
                                                ->maxLength(500)
                                                ->columnSpanFull(),
                                        ]),
                                    ]),

                                Section::make('Branding & Legal')
                                    ->components([
                                        FileUpload::make('watermark')
                                            ->label('Watermark')
                                            ->image()
                                            ->disk('public')
                                            ->directory('site-settings')
                                            ->maxSize(2048),

                                        TextInput::make('copyright')
                                            ->label('Copyright')
                                            ->maxLength(255),

                                        Textarea::make('footer_copyright_text')
                                            ->label('Footer Copyright Text')
                                            ->rows(2)
                                            ->maxLength(500),
                                    ]),

                                Section::make('API Keys')
                                    ->components([
                                        Grid::make(2)->components([
                                            TextInput::make('fcm_api_key')
                                                ->label('API Key from FCM')
                                                ->password() // Hides the key for security
                                                ->revealable() // Allows viewing the key
                                                ->maxLength(255),

                                            TextInput::make('sms_api_key')
                                                ->label('API Key for SMS')
                                                ->password()
                                                ->revealable()
                                                ->maxLength(255),
                                        ]),
                                    ]),
                            ]),

                        Tab::make('Introduction')
                            ->schema([
                                Section::make('App Introduction')
                                    ->description('Manage the splash screen shown when the app starts.')
                                    ->components([
                                        FileUpload::make('splash_screen')
                                            ->label('Splash Screen')
                                            ->image()
                                            ->disk('public')
                                            ->directory('site-settings')
                                            ->maxSize(2048)
                                            ->helperText('Upload a splash screen image (PNG, JPG) - Max 2MB')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::setMany($data);

        Notification::make()
            ->title('Settings updated successfully')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save'),
        ];
    }
}
