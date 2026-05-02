<?php

namespace App\Libraries;

class Utility {

    static function getNestedValue($object, $path)
    {
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (!$object) return null;
            $object = $object->$key ?? null;
        }

        return $object;
    }

    static function parseValue($row, $field, $config = null)
    {
        // ambil value (support nested: perusahaan.nama)
        $value = self::getNestedValue($row, $field);

        // jika bukan array (config sederhana)
        if (!is_array($config)) {
            return $value ?? '-';
        }

        // custom render (paling prioritas)
        if (isset($config['render']) && is_callable($config['render'])) {
            return $config['render']($row);
        }

        $type = $config['type'] ?? null;

        switch ($type) {

            case 'currency':
                return 'Rp ' . number_format($value ?? 0, 0, ',', '.');

            case 'number':
                return number_format($value ?? 0, 0, ',', '.');

            case 'date':
                $format = $config['format'] ?? 'Y-m-d';
                return $value 
                    ? \Carbon\Carbon::parse($value)->format($format)
                    : '-';

            case 'datetime':
                return $value 
                    ? \Carbon\Carbon::parse($value)->format('d-m-Y H:i')
                    : '-';

            case 'boolean':
                return $value ? 'Ya' : 'Tidak';

            case 'badge':
                $color = $config['badge']['color'][$value] ?? 'bg-gray-200';
                $label = $config['badge']['label'][$value];
                return "<span class='px-2 py-1 rounded $color'>{$label}</span>";

            default:
                return $value ?? '-';
        }
    }

    static function parseLinkAction($string, $data)
    {
        $data = $data->toArray();
        foreach ($data as $key => $value) {
            if(!is_array($value))
            {
                $string = str_replace('{' . $key . '}', $value, $string);
            }
        }
        return $string;
    }

}