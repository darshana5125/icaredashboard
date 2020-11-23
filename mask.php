<?php
public function mask($string)
{
    $regex = '/(?:\d[ \t-]*?){13,19}/m';

    $matches = [];

    preg_match_all($regex, $string, $matches);

    // No credit card found
    if (!isset($matches[0]) || empty($matches[0]))
    {
        return $string;
    }

    foreach ($matches as $match_group)
    {
        foreach ($match_group as $match)
        {
            $stripped_match = preg_replace('/[^\d]/', '', $match);

            // Is it a valid Luhn one?
            if (false === $this->_util_luhn->isLuhn($stripped_match))
            {
                continue;
            }

            $card_length = strlen($stripped_match);
            $replacement = str_pad('', $card_length - 4, $this->_replacement) . substr($stripped_match, -4);

            // If so, replace the match
            $string = str_replace($match, $replacement, $string);
        }
    }

    return $string;
}

//$string='[CSR#100005451] SIR 7696 - IPP Posting issue -Customer complaint 4385350200008791';

//mask($string);

echo 'sdd';

?>
