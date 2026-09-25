<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable()
                    ->html()
                    ->formatStateUsing(function (?string $state): ?HtmlString {
                        if (! $state) {
                            return null;
                        }

                        $masked = static::maskEmail($state);
                        $escapedMasked = e($masked);
                        $escapedFull = e($state);

                        return new HtmlString("
                            <div x-data=\"{ isHidden: true }\" class=\"inline-flex items-center gap-1.5\" @click.stop>
                                <span x-show=\"isHidden\" class=\"font-mono text-sm\">{$escapedMasked}</span>
                                <span x-show=\"!isHidden\" x-cloak class=\"font-mono text-sm\">{$escapedFull}</span>
                                <button 
                                    type=\"button\" 
                                    @click.stop=\"isHidden = !isHidden\" 
                                    class=\"p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors rounded hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none\"
                                    :title=\"isHidden ? 'Tampilkan email' : 'Sembunyikan email'\"
                                >
                                    <svg x-show=\"isHidden\" class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" stroke-width=\"1.8\">
                                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z\" />
                                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z\" />
                                    </svg>
                                    <svg x-show=\"!isHidden\" x-cloak class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" stroke-width=\"1.8\">
                                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88\" />
                                    </svg>
                                </button>
                            </div>
                        ");
                    }),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge(),
                IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function maskEmail(?string $email): string
    {
        if (! $email || ! str_contains($email, '@')) {
            return (string) $email;
        }

        [$username, $domain] = explode('@', $email, 2);
        $len = strlen($username);

        if ($len <= 2) {
            $maskedUsername = substr($username, 0, 1) . '*';
        } elseif ($len <= 4) {
            $maskedUsername = substr($username, 0, 1) . str_repeat('*', $len - 2) . substr($username, -1);
        } else {
            $maskedUsername = substr($username, 0, 2) . str_repeat('*', max(3, $len - 3)) . substr($username, -1);
        }

        return $maskedUsername . '@' . $domain;
    }
}
