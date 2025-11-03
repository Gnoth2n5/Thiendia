<?php

namespace App\Filament\Resources\Graves\Schemas;

use App\Models\Cemetery;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;

class GraveForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin nghĩa trang')
                    ->schema([
                        Select::make('cemetery_id')
                            ->label('Nghĩa trang an táng')
                            ->options(function () {
                                $query = Cemetery::query();

                                // Nếu là cán bộ xã/phường, chỉ hiển thị nghĩa trang của xã/phường mình
                                /** @var User $user */
                                $user = auth()->user();
                                if ($user && $user->isCommuneStaff()) {
                                    $query->where('commune', $user->commune);
                                }

                                return $query->pluck('name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                        \Filament\Forms\Components\Hidden::make('plot_id')
                            ->dehydrated(true)
                            ->live(),

                        ViewField::make('plot_grid_simple')
                            ->label('Chọn lô mộ')
                            ->view('filament.forms.components.plot-grid-simple')
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Section::make('Thông tin liệt sĩ')
                    ->description('Thông tin về liệt sĩ an nghỉ tại lăng mộ')
                    ->schema([
                        TextInput::make('deceased_full_name')
                            ->label('Họ và tên liệt sỹ')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Họ và tên đầy đủ của liệt sỹ')
                            ->columnSpan(2),

                        TextInput::make('birth_year')
                            ->label('Năm sinh')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100)
                            ->placeholder('1950'),

                        DatePicker::make('deceased_birth_date')
                            ->label('Ngày sinh đầy đủ')
                            ->displayFormat('d/m/Y')
                            ->helperText('(Tùy chọn nếu biết đầy đủ ngày sinh)'),

                        TextInput::make('rank_and_unit')
                            ->label('Cấp bậc, chức vụ, đơn vị')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Trung sĩ, Tiểu đoàn 5, Trung đoàn 88')
                            ->columnSpan(2),

                        TextInput::make('position')
                            ->label('Chức vụ')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Tiểu đội trưởng'),

                        DatePicker::make('deceased_death_date')
                            ->label('Ngày tháng năm hy sinh')
                            ->displayFormat('d/m/Y')
                            ->required(),

                        Select::make('deceased_gender')
                            ->label('Giới tính')
                            ->options([
                                'nam' => 'Nam',
                                'nữ' => 'Nữ',
                            ])
                            ->default('nam'),

                        DatePicker::make('burial_date')
                            ->label('Ngày an táng')
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(3),

                Section::make('Giấy tờ và hồ sơ')
                    ->schema([
                        TextInput::make('certificate_number')
                            ->label('Số bằng TQGC')
                            ->maxLength(255)
                            ->placeholder('Số bằng Tổ quốc ghi công'),

                        TextInput::make('decision_number')
                            ->label('Số QĐ')
                            ->maxLength(255)
                            ->placeholder('Số quyết định'),

                        DatePicker::make('decision_date')
                            ->label('Ngày, tháng, năm cấp QĐ')
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Thông tin thân nhân')
                    ->schema([
                        TextInput::make('deceased_relationship')
                            ->label('Quan hệ với liệt sỹ')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: Con trai, Con gái, Cháu...'),

                        TextInput::make('next_of_kin')
                            ->label('Thân nhân')
                            ->maxLength(255)
                            ->placeholder('Tên người thân'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Hình ảnh')
                    ->schema([
                        FileUpload::make('deceased_photo')
                            ->label('Ảnh liệt sỹ')
                            ->image()
                            ->directory('deceased-photos')
                            ->getUploadedFileNameForStorageUsing(function ($file): string {
                                // Tạo tên file ngắn: timestamp-random.extension
                                $timestamp = now()->timestamp;
                                $random = strtolower(substr(md5(uniqid()), 0, 6));
                                $extension = $file->getClientOriginalExtension();

                                return "{$timestamp}-{$random}.{$extension}";
                            })
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '4:5',
                                '3:4',
                            ])
                            ->maxSize(2048)
                            ->helperText('Ảnh dạng chữ nhật dọc (tối đa 2MB)'),

                        FileUpload::make('grave_photos')
                            ->label('Ảnh bia mộ')
                            ->image()
                            ->multiple()
                            ->directory('grave-photos')
                            ->getUploadedFileNameForStorageUsing(function ($file): string {
                                // Tạo tên file ngắn: timestamp-random.extension
                                $timestamp = now()->timestamp;
                                $random = strtolower(substr(md5(uniqid()), 0, 6));
                                $extension = $file->getClientOriginalExtension();

                                return "{$timestamp}-{$random}.{$extension}";
                            })
                            ->visibility('public')
                            ->imageEditor()
                            ->reorderable()
                            ->maxFiles(5)
                            ->maxSize(2048)
                            ->helperText('Tối đa 5 ảnh, mỗi ảnh tối đa 2MB'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Thông tin bổ sung')
                    ->schema([
                        Select::make('grave_type')
                            ->label('Loại mộ')
                            ->options([
                                'đất' => 'Mộ đất',
                                'xi_măng' => 'Mộ xi măng',
                                'đá' => 'Mộ đá',
                                'gỗ' => 'Mộ gỗ',
                                'khác' => 'Loại khác',
                            ])
                            ->default('đá'),

                        Textarea::make('location_description')
                            ->label('Vị trí trong nghĩa trang')
                            ->rows(2)
                            ->placeholder('Ví dụ: Khu A, hàng 3, mộ số 15')
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('Ghi chú')
                            ->rows(3)
                            ->placeholder('Ghi chú về tiểu sử, lịch sử hy sinh, công lao...')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Vị trí trên bản đồ')
                    ->schema([
                        TextInput::make('latitude')
                            ->label('Vĩ độ (Latitude)')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('20.250600')
                            ->helperText('Tọa độ vĩ độ GPS'),

                        TextInput::make('longitude')
                            ->label('Kinh độ (Longitude)')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('105.974500')
                            ->helperText('Tọa độ kinh độ GPS'),

                        ViewField::make('map_picker')
                            ->view('filament.forms.components.map-picker')
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Thông tin liên hệ')
                    ->schema([
                        TextInput::make('contact_info.phone')
                            ->label('Số điện thoại')
                            ->tel()
                            ->placeholder('0912345678'),

                        TextInput::make('contact_info.email')
                            ->label('Email')
                            ->email()
                            ->placeholder('email@example.com'),

                        TextInput::make('contact_info.address')
                            ->label('Địa chỉ liên hệ')
                            ->placeholder('Địa chỉ để liên lạc')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

            ]);
    }
}
