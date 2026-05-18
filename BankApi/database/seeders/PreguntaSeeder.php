<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntaSeeder extends Seeder
{
    public function run(): void
    {
        $preguntes = [
            // Historia (cat 1)
            ['enunciat' => 'En quin any va esclatar la Primera Guerra Mundial?', 'dificultat' => 'Fàcil', 'categoria_id' => 1],
            ['enunciat' => 'Qui va ser el primer president dels Estats Units?', 'dificultat' => 'Fàcil', 'categoria_id' => 1],
            ['enunciat' => 'En quin any va caure el mur de Berlín?', 'dificultat' => 'Mitja', 'categoria_id' => 1],
            ['enunciat' => 'Quina civilització va construir les piràmides de Giza?', 'dificultat' => 'Fàcil', 'categoria_id' => 1],
            ['enunciat' => 'En quin any va tenir lloc la Revolució Francesa?', 'dificultat' => 'Mitja', 'categoria_id' => 1],
            // Esports (cat 2)
            ['enunciat' => 'Quants jugadors té un equip de futbol?', 'dificultat' => 'Fàcil', 'categoria_id' => 2],
            ['enunciat' => 'En quin país es va celebrar el Mundial de Futbol 2022?', 'dificultat' => 'Mitja', 'categoria_id' => 2],
            ['enunciat' => 'Quants anells té el símbol olímpic?', 'dificultat' => 'Fàcil', 'categoria_id' => 2],
            ['enunciat' => 'Qui té el rècord de gols en una sola temporada de Champions League?', 'dificultat' => 'Difícil', 'categoria_id' => 2],
            ['enunciat' => 'Quin país ha guanyat més Copes del Món de futbol?', 'dificultat' => 'Mitja', 'categoria_id' => 2],
            // Art (cat 3)
            ['enunciat' => 'Qui va pintar La Gioconda?', 'dificultat' => 'Fàcil', 'categoria_id' => 3],
            ['enunciat' => 'A quin museu es troba La Gioconda?', 'dificultat' => 'Mitja', 'categoria_id' => 3],
            ['enunciat' => 'Qui va esculpir el David?', 'dificultat' => 'Mitja', 'categoria_id' => 3],
            ['enunciat' => 'De quin moviment artístic era Salvador Dalí?', 'dificultat' => 'Mitja', 'categoria_id' => 3],
            ['enunciat' => 'Quina és l\'obra més famosa de Picasso relacionada amb la Guerra Civil Espanyola?', 'dificultat' => 'Difícil', 'categoria_id' => 3],
        ];

        $respostes = [
            // P1 - Primera Guerra Mundial
            [['text' => '1914', 'es_correcta' => true], ['text' => '1918', 'es_correcta' => false], ['text' => '1939', 'es_correcta' => false]],
            // P2 - Primer president USA
            [['text' => 'George Washington', 'es_correcta' => true], ['text' => 'Abraham Lincoln', 'es_correcta' => false], ['text' => 'Thomas Jefferson', 'es_correcta' => false]],
            // P3 - Mur de Berlín
            [['text' => '1989', 'es_correcta' => true], ['text' => '1991', 'es_correcta' => false], ['text' => '1985', 'es_correcta' => false]],
            // P4 - Piràmides
            [['text' => 'Egipcis antics', 'es_correcta' => true], ['text' => 'Romans', 'es_correcta' => false], ['text' => 'Grecs', 'es_correcta' => false]],
            // P5 - Revolució Francesa
            [['text' => '1789', 'es_correcta' => true], ['text' => '1776', 'es_correcta' => false], ['text' => '1804', 'es_correcta' => false]],
            // P6 - Jugadors futbol
            [['text' => '11', 'es_correcta' => true], ['text' => '10', 'es_correcta' => false], ['text' => '12', 'es_correcta' => false]],
            // P7 - Mundial 2022
            [['text' => 'Qatar', 'es_correcta' => true], ['text' => 'Aràbia Saudita', 'es_correcta' => false], ['text' => 'Emirats Àrabs', 'es_correcta' => false]],
            // P8 - Anells olímpics
            [['text' => '5', 'es_correcta' => true], ['text' => '4', 'es_correcta' => false], ['text' => '6', 'es_correcta' => false]],
            // P9 - Rècord Champions
            [['text' => 'Cristiano Ronaldo', 'es_correcta' => true], ['text' => 'Lionel Messi', 'es_correcta' => false], ['text' => 'Robert Lewandowski', 'es_correcta' => false]],
            // P10 - Copes del Món
            [['text' => 'Brasil', 'es_correcta' => true], ['text' => 'Alemanya', 'es_correcta' => false], ['text' => 'Itàlia', 'es_correcta' => false]],
            // P11 - Gioconda
            [['text' => 'Leonardo da Vinci', 'es_correcta' => true], ['text' => 'Michelangelo', 'es_correcta' => false], ['text' => 'Rafael', 'es_correcta' => false]],
            // P12 - Museu Gioconda
            [['text' => 'Louvre (París)', 'es_correcta' => true], ['text' => 'Prado (Madrid)', 'es_correcta' => false], ['text' => 'Uffizi (Florència)', 'es_correcta' => false]],
            // P13 - David
            [['text' => 'Michelangelo', 'es_correcta' => true], ['text' => 'Leonardo da Vinci', 'es_correcta' => false], ['text' => 'Donatello', 'es_correcta' => false]],
            // P14 - Dalí
            [['text' => 'Surrealisme', 'es_correcta' => true], ['text' => 'Cubisme', 'es_correcta' => false], ['text' => 'Impressionisme', 'es_correcta' => false]],
            // P15 - Picasso
            [['text' => 'Guernica', 'es_correcta' => true], ['text' => 'Les Demoiselles d\'Avignon', 'es_correcta' => false], ['text' => 'El Guerrer', 'es_correcta' => false]],
        ];

        foreach ($preguntes as $i => $preguntaData) {
            $id = DB::table('preguntes')->insertGetId(array_merge($preguntaData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            foreach ($respostes[$i] as $resposta) {
                DB::table('respostes')->insert(array_merge($resposta, [
                    'pregunta_id' => $id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]));
            }
        }
    }
}
