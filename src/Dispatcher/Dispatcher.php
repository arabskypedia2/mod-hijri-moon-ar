<?php

/**
 * Copyright (C) 2026 ArabSkyPedia.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see <https://www.gnu.org/licenses/>.
 *
 * @package     ArabSkyPedia.Module
 * @subpackage  mod_hijri_moon_ar
 */

namespace ArabSkyPedia\Module\HijriMoonAr\Site\Dispatcher;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Dispatcher class for mod_hijri_moon_ar.
 *
 * The layout (tmpl/default.php) computes the Hijri date and moon phase
 * via static calls on the helper, so no extra layout data is needed here.
 */
class Dispatcher extends AbstractModuleDispatcher
{
}
