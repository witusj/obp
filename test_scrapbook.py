import numpy as np
from scrapbook import sliding_window

def test_sliding_window():
    # Test case 1
    arr1 = np.array([1, 2, 3, 4, 5])
    window_size1 = 3
    expected_output1 = np.array([[1, 2, 3], [2, 3, 4], [3, 4, 5]])
    assert np.array_equal(sliding_window(arr1, window_size1), expected_output1)
    
    # Test case 2
    arr2 = np.array([1, 2, 3, 4, 5])
    window_size2 = 1
    expected_output2 = np.array([[1], [2], [3], [4], [5]])
    assert np.array_equal(sliding_window(arr2, window_size2), expected_output2)
    
    # Test case 3
    arr3 = np.array([1, 2, 3, 4, 5])
    window_size3 = 5
    expected_output3 = np.array([[1, 2, 3, 4, 5]])
    assert np.array_equal(sliding_window(arr3, window_size3), expected_output3)