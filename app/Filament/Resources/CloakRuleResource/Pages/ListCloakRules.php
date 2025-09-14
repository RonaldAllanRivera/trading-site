<?php

namespace App\Filament\Resources\CloakRuleResource\Pages;

use App\Filament\Resources\CloakRuleResource;
use App\Models\CloakRule;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCloakRules extends ListRecords
{
    protected static string $resource = CloakRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('testCloaker')
                ->label('Test Cloaker')
                ->icon('heroicon-o-beaker')
                ->color('gray')
                ->form([
                    // Use Rule selector (auto-fill from rule)
                    Forms\Components\Select::make('rule_id')
                        ->label('Use Rule')
                        ->options(fn () => CloakRule::query()
                            ->where('status', 'active')
                            ->orderBy('id')
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->live()
                        ->helperText('Pick an active rule to auto-fill a matching test. You can still tweak values below.')
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (!$state) {
                                return;
                            }
                            $rule = CloakRule::find($state);
                            if (! $rule) {
                                return;
                            }
                            $patterns = preg_split('/[\r\n,]+/', (string) $rule->pattern, -1, PREG_SPLIT_NO_EMPTY);
                            $first = trim($patterns[0] ?? '');
                            // Set preset to custom when rule-driven
                            $set('preset', 'custom');
                            switch ($rule->match_type) {
                                case 'ua':
                                    $set('user_agent_choice', 'custom');
                                    $set('user_agent', $first);
                                    break;
                                case 'referrer':
                                    $set('referrer_choice', 'custom');
                                    $set('referrer', $first);
                                    break;
                                case 'country':
                                    $set('country_choice', 'custom');
                                    $set('country', strtoupper($first));
                                    break;
                                case 'param':
                                    if (str_contains($first, '=')) {
                                        [$k, $v] = array_map('trim', explode('=', $first, 2));
                                        $set('params_kv', [$k => $v]);
                                    } else {
                                        // If only a fragment, put it as a value under a generic key
                                        $set('params_kv', ['q' => $first]);
                                    }
                                    break;
                                case 'ip':
                                    $set('ip_choice', 'custom');
                                    $set('ip', $first);
                                    break;
                            }
                        }),
                    // Presets
                    Forms\Components\Select::make('preset')
                        ->label('Shortcut Preset')
                        ->options([
                            'normal_user' => 'Normal User',
                            'google_reviewers' => 'Google Reviewers',
                            'facebook_reviewers' => 'Facebook Reviewers',
                            'custom' => 'Custom',
                        ])
                        ->default('normal_user')
                        ->native(false)
                        ->live(),
                    // IP selection
                    Forms\Components\Select::make('ip_choice')
                        ->label('IP')
                        ->options([
                            '1.1.1.1' => '1.1.1.1 (Cloudflare DNS)',
                            '8.8.8.8' => '8.8.8.8 (Google DNS)',
                            '203.0.113.10' => '203.0.113.10 (Test IP A)',
                            '198.51.100.20' => '198.51.100.20 (Test IP B)',
                            'custom' => 'Custom…',
                        ])
                        ->live()
                        ->native(false)
                        ->placeholder('Select IP (optional)')
                        ->preload(),
                    Forms\Components\TextInput::make('ip')
                        ->label('Custom IP')
                        ->placeholder('e.g., 192.0.2.1')
                        ->visible(fn ($get) => $get('ip_choice') === 'custom'),

                    // Country selection
                    Forms\Components\Select::make('country_choice')
                        ->label('Country (ISO 2)')
                        ->options([
                            'SG' => 'SG (Singapore)',
                            'US' => 'US (United States)',
                            'GB' => 'GB (United Kingdom)',
                            'PH' => 'PH (Philippines)',
                            'AU' => 'AU (Australia)',
                            'CA' => 'CA (Canada)',
                            'DE' => 'DE (Germany)',
                            'FR' => 'FR (France)',
                            'ES' => 'ES (Spain)',
                            'IT' => 'IT (Italy)',
                            'NL' => 'NL (Netherlands)',
                            'custom' => 'Custom…',
                        ])
                        ->live()
                        ->native(false)
                        ->placeholder('Select Country (optional)')
                        ->preload(),
                    Forms\Components\TextInput::make('country')
                        ->label('Custom Country (ISO 2)')
                        ->maxLength(2)
                        ->placeholder('SG')
                        ->visible(fn ($get) => $get('country_choice') === 'custom'),

                    // User-Agent selection
                    Forms\Components\Select::make('user_agent_choice')
                        ->label('User Agent')
                        ->options([
                            'desktop' => 'Mozilla/5.0 (Desktop)',
                            'mobile' => 'Mozilla/5.0 (Mobile)',
                            'googlebot' => 'Googlebot',
                            'adsbot' => 'AdsBot-Google',
                            'fbext' => 'facebookexternalhit',
                            'facebot' => 'Facebot',
                            'custom' => 'Custom…',
                        ])
                        ->live()
                        ->native(false)
                        ->default('desktop')
                        ->preload(),
                    Forms\Components\Textarea::make('user_agent')
                        ->label('Custom User Agent')
                        ->rows(2)
                        ->visible(fn ($get) => $get('user_agent_choice') === 'custom'),

                    // Referrer selection
                    Forms\Components\Select::make('referrer_choice')
                        ->label('Referrer')
                        ->options([
                            'none' => 'None',
                            'https://google.com' => 'https://google.com',
                            'https://facebook.com/ads' => 'https://facebook.com/ads',
                            'https://t.co' => 'https://t.co',
                            'custom' => 'Custom…',
                        ])
                        ->live()
                        ->native(false)
                        ->default('none')
                        ->preload(),
                    Forms\Components\TextInput::make('referrer')
                        ->label('Custom Referrer')
                        ->placeholder('https://example.com/path')
                        ->visible(fn ($get) => $get('referrer_choice') === 'custom'),

                    // Params as key/value
                    Forms\Components\KeyValue::make('params_kv')
                        ->label('Query Params')
                        ->keyLabel('Key')
                        ->valueLabel('Value')
                        ->addButtonLabel('Add Param')
                        ->reorderable(),
                ])
                ->action(function (array $data) {
                    // Resolve IP
                    $ip = (string)($data['ip_choice'] ?? '');
                    if ($ip === 'custom') {
                        $ip = trim((string)($data['ip'] ?? '1.1.1.1'));
                    }
                    if ($ip === '') {
                        $ip = '1.1.1.1';
                    }

                    // Resolve Country
                    $country = (string)($data['country_choice'] ?? '');
                    if ($country === 'custom') {
                        $country = strtoupper(trim((string)($data['country'] ?? '')));
                    }

                    // Resolve User Agent
                    $uaChoice = (string)($data['user_agent_choice'] ?? 'desktop');
                    $uaMap = [
                        'desktop' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125 Safari/537.36',
                        'mobile' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1',
                        'googlebot' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
                        'adsbot' => 'AdsBot-Google (+http://www.google.com/adsbot.html)',
                        'fbext' => 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
                        'facebot' => 'Facebot',
                    ];
                    $ua = $uaChoice === 'custom'
                        ? (string)($data['user_agent'] ?? '')
                        : ($uaMap[$uaChoice] ?? $uaMap['desktop']);

                    // Resolve Referrer
                    $refChoice = (string)($data['referrer_choice'] ?? 'none');
                    $ref = $refChoice === 'custom'
                        ? (string)($data['referrer'] ?? '')
                        : ($refChoice === 'none' ? '' : $refChoice);

                    // Resolve Params
                    $params = [];
                    if (isset($data['params_kv']) && is_array($data['params_kv'])) {
                        foreach ($data['params_kv'] as $k => $v) {
                            if ($k === '' || $v === null) continue;
                            $params[(string)$k] = (string)$v;
                        }
                    }

                    // Apply preset overrides
                    $preset = (string)($data['preset'] ?? 'custom');
                    if ($preset === 'google_reviewers') {
                        $ua = $uaMap['googlebot'];
                        $ref = '';
                        $params['utm_source'] = $params['utm_source'] ?? 'google';
                    } elseif ($preset === 'facebook_reviewers') {
                        $ua = $uaMap['fbext'];
                        $ref = 'https://facebook.com/ads';
                        $params['utm_source'] = $params['utm_source'] ?? 'facebook';
                    }

                    $matchedRule = null;
                    $decision = 'allow';

                    $rules = CloakRule::where('status', 'active')->orderBy('id')->get();
                    foreach ($rules as $rule) {
                        $patterns = preg_split('/[\r\n,]+/', (string)$rule->pattern, -1, PREG_SPLIT_NO_EMPTY);
                        $matched = false;
                        foreach ($patterns as $pattern) {
                            $p = trim($pattern);
                            if ($p === '') continue;
                            switch ($rule->match_type) {
                                case 'ip':
                                    $matched = ($ip === $p);
                                    break;
                                case 'country':
                                    $matched = ($country !== '' && strtoupper($p) === $country);
                                    break;
                                case 'ua':
                                    $matched = (stripos($ua, $p) !== false);
                                    break;
                                case 'referrer':
                                    $matched = ($ref !== '' && stripos($ref, $p) !== false);
                                    break;
                                case 'param':
                                    if (str_contains($p, '=')) {
                                        [$k, $v] = array_map('trim', explode('=', $p, 2));
                                        $matched = isset($params[$k]) && strcasecmp((string)$params[$k], $v) === 0;
                                    } else {
                                        $matched = (stripos(http_build_query($params), $p) !== false);
                                    }
                                    break;
                            }
                            if ($matched) break;
                        }

                        if ($matched) {
                            $matchedRule = $rule;
                            $decision = ($rule->mode === 'whitelist') ? 'offer' : 'safe';
                            break;
                        }
                    }

                    $title = $matchedRule
                        ? ("Decision: " . strtoupper($decision) . " • Rule: " . $matchedRule->name)
                        : 'Decision: allow (no rule applied)';

                    // Build live-run URLs (note: UA/Referrer cannot be forced via link)
                    $query = $params;
                    if ($country !== '') {
                        $query['__country'] = $country;
                    }
                    if ($ua !== '') {
                        $query['__ua'] = $ua;
                    }
                    if ($ref !== '') {
                        $query['__ref'] = $ref;
                    }
                    $homeUrl = url('/');
                    $signupUrl = url('/sign-up');
                    if (!empty($query)) {
                        $qs = http_build_query($query);
                        $homeUrl .= '?' . $qs;
                        $signupUrl .= '?' . $qs;
                    }

                    Notification::make()
                        ->title($title)
                        ->success()
                        ->actions([
                            Actions\Action::make('openHome')->label('Open /')->url($homeUrl)->openUrlInNewTab(),
                            Actions\Action::make('openSignup')->label('Open /sign-up')->url($signupUrl)->openUrlInNewTab(),
                        ])
                        ->send();
                }),

            Actions\Action::make('resetCounters')
                ->label('Reset Counters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->action(function () {
                    CloakRule::query()->update(['hits_safe' => 0, 'hits_offer' => 0]);
                    Notification::make()->title('Cloaker counters reset')->success()->send();
                }),
        ];
    }
}
